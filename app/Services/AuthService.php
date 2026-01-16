<?php

namespace App\Services;

use App\Mail\RegisterOtpMail;
use App\Mail\ResetPasswordOtpMail;
use App\Models\Role;
use App\Repositories\UserRepository;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use Illuminate\Validation\ValidationException;
use BaconQrCode\Writer;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PragmaRX\Google2FA\Google2FA;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers($request, $limit)
    {
        return $this->userRepository->getAll($request->input('search'), $limit);
    }

    public function initiateRegistration(array $data)
    {
        $email = $data['email'];
        $otp = rand(100000, 999999);

        $roleId = $data['role_id'] ?? 3;

        $registrationData = [
            'name' => $data['name'],
            'email' => $email,
            'phone_number' => $data['phone'],
            'role_id' =>  $roleId,
            'password' => Hash::make($data['password']),
            'otp' => $otp
        ];

        Cache::put('temp_reg_' . $email, $registrationData, 600);

        try {
            Mail::to($email)->send(new RegisterOtpMail($otp));
        } catch (\Exception $e) {
            Log::error("Gagal kirim email ke {$email}: " . $e->getMessage());
            throw new \Exception("Gagal mengirim kode OTP ke email. Pastikan koneksi internet aman.");
        }

        Log::info("OTP Register untuk {$email}: {$otp}");
    }

    public function verifyOtpAndCreateUser(string $email, string $otpInput)
    {
        $cachedData = Cache::get('temp_reg_' . $email);

        if (!$cachedData) {
            throw new Exception("Sesi registrasi habis atau data tidak ditemukan. Silakan daftar ulang.");
        }

        if ($cachedData['otp'] != $otpInput) {
            throw new Exception("Kode OTP salah.");
        }

        $memberRole = Role::where('id', $cachedData['role_id'])->first();
        if (!$memberRole) throw new Exception("Role member tidak ditemukan.");

        $finalUserData = [
            'name' => $cachedData['name'],
            'email' => $cachedData['email'],
            'phone_number' => $cachedData['phone_number'],
            'password' => $cachedData['password'],
            'role_id' => $memberRole->id,
        ];

        $user = $this->userRepository->create($finalUserData);

        Cache::forget('temp_reg_' . $email);

        return $user;
    }

    public function login(array $credentials, bool $remember = false)
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new Exception("Email atau kata sandi salah.");
        }

        if (!$user->is_active) {
            throw new Exception("Akun Anda telah dinonaktifkan.");
        }

        if ($user->two_factor_enabled) {
            return [
                'status' => '2fa_required',
                'user' => $user
            ];
        }

        Auth::login($user, $remember);

        return [
            'status' => 'success',
            'user' => $user
        ];
    }

    public function verifyLogin2fa($userId, $otp, $remember = false)
    {
        $user = $this->userRepository->findById($userId);

        if (!$user) {
            throw new Exception("Sesi login tidak valid.");
        }

        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($user->google2fa_secret, $otp, 1);

        if ($valid) {
            Auth::login($user, $remember);
            return $user;
        }

        throw new Exception("Kode Authenticator salah.");
    }

    public function get2faSetupData($user)
    {
        $google2fa = new Google2FA();

        $secretKey = $google2fa->generateSecretKey();

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secretKey
        );

        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeImage = $writer->writeString($qrCodeUrl);

        return [
            'secret' => $secretKey,
            'qr_code_image' => $qrCodeImage
        ];
    }

    // Verifikasi & Aktifkan 2FA
    public function enable2fa($user, string $secret, string $otp)
    {
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($secret, $otp);

        if (!$valid) {
            throw new \Exception("Kode OTP salah. Pastikan Anda scan QR Code dengan benar.");
        }

        return $this->userRepository->update($user, [
            'google2fa_secret' => $secret,
            'two_factor_enabled' => true
        ]);
    }

    // Disable 2FA
    public function disableTwoFactor(string $currentPassword)
    {
        $user = Auth::user();

        if (!Hash::check($currentPassword, $user->password)) {
            throw new Exception("Kata sandi salah. Gagal menonaktifkan 2FA.");
        }

        return $this->userRepository->update($user, [
            'two_factor_enabled' => false,
            'google2fa_secret' => null
        ]);
    }

    public function createUser($data)
    {
        if ($this->userRepository->findByEmail($data['email'])) {
            throw ValidationException::withMessages(['email' => 'Email sudah terdaftar.']);
        }

        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'],
            'phone_number' => $data['phone'] ?? null,
            'is_active' => $data['is_active'] ?? true,
            'email_verified_at' => now(),
        ];

        return $this->userRepository->create($userData);
    }

    public function updateUser($id, $data)
    {
        $user = $this->userRepository->findById($id);

        if ($user->email !== $data['email']) {
            if ($this->userRepository->findByEmail($data['email'])) {
                throw ValidationException::withMessages(['email' => 'Email sudah digunakan user lain.']);
            }
        }

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role_id'],
            'phone_number' => $data['phone'] ?? null,
            'is_active' => isset($data['is_active']) ? 1 : 0,
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->update($user, $updateData);
    }

    public function initiateForgotPassword(array $data)
    {
        $email = $data['email'];

        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
            throw new Exception("Email tidak terdaftar dalam sistem.");
        }

        $otp = rand(100000, 999999);

        $resetData = [
            'email' => $email,
            'password' => Hash::make($data['password']),
            'otp' => $otp
        ];

        Cache::put('temp_reset_' . $email, $resetData, 600);

        try {
            Mail::to($email)->send(new ResetPasswordOtpMail($otp));
        } catch (\Exception $e) {
            Log::error("Gagal kirim email reset ke {$email}: " . $e->getMessage());
            throw new Exception("Gagal mengirim kode OTP. Coba lagi nanti.");
        }
    }

    public function verifyForgotOtp(string $email, string $otpInput)
    {
        $cachedData = Cache::get('temp_reset_' . $email);

        if (!$cachedData) {
            throw new Exception("Sesi reset password habis. Silakan ulangi permintaan lupa sandi.");
        }

        // 2. Validasi OTP
        if ($cachedData['otp'] != $otpInput) {
            throw new Exception("Kode OTP salah.");
        }

        // 3. Update Password User
        $user = $this->userRepository->findByEmail($email);
        if ($user) {
            $this->userRepository->update($user, [
                'password' => $cachedData['password']
            ]);
        }

        // 4. Hapus Cache
        Cache::forget('temp_reset_' . $email);

        return true;
    }
}
