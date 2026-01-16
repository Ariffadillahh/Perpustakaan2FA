<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\DisableTwoFactorRequest;
use App\Http\Requests\Auth\EnableTwoFactorRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterVerifyRequest;
use App\Http\Requests\Auth\RegisterInitiateRequest;
use App\Http\Requests\Auth\VerifyLogin2faRequest;
use App\Services\AuthService;
use App\Services\BookService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;
    protected $bookService;

    public function __construct(AuthService $authService, BookService $bookService)
    {
        $this->authService = $authService;
        $this->bookService = $bookService;
    }

    public function index(Request $request)
    {
        $limit = 8;

        $search = $request->input('search');

        $books = $this->bookService->getAllBooks($limit, $search);

        return view('landing', compact('books', 'search'));
    }

    public function users(Request $request)
    {
        $limit = 10;
        $users = $this->authService->getAllUsers($request, $limit);
        return view('dashboard.users.index', compact('users'));
    }

    // --- REGISTER FLOW ---
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(RegisterInitiateRequest $request)
    {
        try {
            $this->authService->initiateRegistration($request->validated());

            return redirect()->route('auth.otp.form')
                ->with([
                    'success' => 'Kode OTP telah dikirim ke email Anda. Cek Log Laravel.',
                    'email' => $request->email
                ]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function showOtpForm()
    {
        if (!session('email') && !old('email')) {
            return redirect()->route('auth.register');
        }

        return view('auth.verify-otp');
    }

    public function verifyOtp(RegisterVerifyRequest $request)
    {
        try {
            $user = $this->authService->verifyOtpAndCreateUser(
                $request->email,
                $request->otp
            );

            Auth::login($user);

            return $this->redirectUserBasedOnRole($user);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('email', $request->email)
                ->with('error', $e->getMessage());
        }
    }

    // --- LOGIN FLOW ---
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $remember = $request->boolean('remember');

            $result = $this->authService->login($credentials, $remember);

            if ($result['status'] === '2fa_required') {
                session([
                    'auth.2fa.id' => $result['user']->id,
                    'auth.2fa.remember' => $remember
                ]);

                return redirect()->route('auth.login.2fa');
            }

            $request->session()->regenerate();

            return $this->redirectUserBasedOnRole($result['user']);
        } catch (\Exception $e) {
            return back()->withInput(['email' => $request->email])->with('error', $e->getMessage());
        }
    }

    public function showLogin2faForm()
    {
        if (!session('auth.2fa.id')) {
            return redirect()->route('login');
        }
        return view('auth.login-2fa');
    }

    public function verifyLogin2fa(VerifyLogin2faRequest $request)
    {
        try {
            $userId = session('auth.2fa.id');
            $remember = session('auth.2fa.remember', false);

            $user = $this->authService->verifyLogin2fa($userId, $request->otp, $remember);

            session()->forget(['auth.2fa.id', 'auth.2fa.remember']);

            $request->session()->regenerate();
            return $this->redirectUserBasedOnRole($user);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah keluar.');
    }

    // --- 2FA MANAGEMENT ---
    public function show2faSetup()
    {
        $data = $this->authService->get2faSetupData(Auth::user());

        return view('auth.2fa-setup', [
            'secret' => $data['secret'],
            'qrCode' => $data['qr_code_image']
        ]);
    }

    public function show2faSetupDashboard()
    {
        $data = $this->authService->get2faSetupData(Auth::user());

        return view('dashboard.2fa-setup', [
            'secret' => $data['secret'],
            'qrCode' => $data['qr_code_image']
        ]);
    }

    public function enable2fa(EnableTwoFactorRequest $request)
    {
        try {
            $this->authService->enable2fa(
                Auth::user(),
                $request->secret,
                $request->otp
            );

            return redirect()->route('profile.index')
                ->with('success', 'Autentikasi 2 Faktor berhasil diaktifkan!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function disable2fa(DisableTwoFactorRequest $request)
    {
        try {
            $this->authService->disableTwoFactor($request->current_password);

            return back()->with('success', 'Autentikasi 2 Faktor berhasil dinonaktifkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['current_password' => $e->getMessage()]);
        }
    }

    public function store(RegisterInitiateRequest $request)
    {
        try {
            $this->authService->createUser($request->validated());

            return redirect()->route('admin.index')
                ->with('success', 'Pengguna berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function update(RegisterInitiateRequest $request, $id)
    {
        try {
            $this->authService->updateUser($id, $request->validated());

            return redirect()->route('admin.index')
                ->with('success', 'Data pengguna diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    private function redirectUserBasedOnRole($user)
    {
        if ((int)$user->role_id === 3) {
            return redirect()->route('landing')
                ->with('success', 'Selamat Datang Kembali!');
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Selamat Datang!');
    }

    public function initiateForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal 6 karakter.'
        ]);

        try {
            $this->authService->initiateForgotPassword($request->only('email', 'password'));

            return redirect()->route('auth.forgot.otp')
                ->with([
                    'success' => 'Kode OTP reset password telah dikirim ke email Anda.',
                    'email' => $request->email
                ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())
                ->with('open_forgot_modal', true);
        }
    }

    public function showForgotOtpForm()
    {
        if (!session('email') && !old('email')) {
            return redirect()->route('login');
        }
        return view('auth.verify-forgot-otp');
    }

    public function verifyForgotOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
            'email' => 'required|email'
        ]);

        try {
            $this->authService->verifyForgotOtp($request->email, $request->otp);

            return redirect()->route('login')
                ->with('success', 'Kata sandi berhasil diubah! Silakan masuk dengan sandi baru.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
