<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Exception;

class ProfileService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function updateProfileInfo(array $data)
    {
        $user = Auth::user();

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
        ];

        return $this->userRepository->update($user, $updateData);
    }

    public function changePassword(string $currentPassword, string $newPassword)
    {
        $user = Auth::user();

        if (!Hash::check($currentPassword, $user->password)) {
            throw new Exception("Kata sandi saat ini salah.");
        }

        return $this->userRepository->update($user, [
            'password' => Hash::make($newPassword)
        ]);
    }

   
}
