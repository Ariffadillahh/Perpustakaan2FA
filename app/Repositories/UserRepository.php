<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getAll($search = null, $limit = 10)
    {
        $query = User::with('role')->latest();

        if (empty($search)) {
            return $query->paginate($limit);
        }

        return $query->get()->filter(function ($user) use ($search) {
            return stripos($user->name, $search) !== false ||
                stripos($user->email, $search) !== false;
        })->toQuery()->paginate($limit);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function findByEmail(string $email)
    {
        return User::all()->first(function ($user) use ($email) {
            return $user->email === $email;
        });
    }

    public function findById(string $id)
    {
        return User::find($id);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);
        return $user;
    }
}
