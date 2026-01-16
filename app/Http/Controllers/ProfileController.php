<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        return view('profile.index', [
            'user' => Auth::user()
        ]);
    }

    public function dashboardProfile()
    {
        return view('dashboard.profile', [
            'user' => Auth::user()
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $this->profileService->updateProfileInfo($request->validated());

            return back()->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            $this->profileService->changePassword(
                $request->current_password,
                $request->password
            );

            return back()->with('success', 'Kata sandi berhasil diubah.');
        } catch (\Exception $e) {
            return back()->withErrors(['current_password' => $e->getMessage()]);
        }
    }
}
