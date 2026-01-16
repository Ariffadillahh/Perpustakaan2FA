<?php

namespace App\Repositories;

use App\Models\Loan;

class LoanRepository
{
    public function all($search = null, $perPage = 10)
    {
        // 1. Eager Loading ('with') SANGAT PENTING
        // Kita wajib load 'book' dan 'user' agar di view bisa panggil $loan->user->name
        $query = Loan::with(['book', 'user']);

        // 2. Logika Pencarian (Search)
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                // Cari berdasarkan Nama Peminjam (Relasi User)
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%"); // Opsional cari email
                })
                    // ATAU Cari berdasarkan Judul Buku (Relasi Book)
                    ->orWhereHas('book', function ($b) use ($search) {
                        $b->where('name', 'LIKE', "%{$search}%"); // Pastikan kolom judul buku adalah 'name' atau 'title'
                    });
            });
        }

        // 3. Return dengan urutan terbaru dan Pagination
        // paginate($perPage) ini yang memungkinkan Anda pakai $loans->links() di View
        return $query->latest()->paginate($perPage);
    }

    public function getByUserId($userId)
    {
        return Loan::with(['book'])->where('user_id', $userId)->latest()->get();
    }

    public function find($id)
    {
        return Loan::with(['book', 'user'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Loan::create($data);
    }

    public function update($id, array $data)
    {
        $loan = Loan::findOrFail($id);
        $loan->update($data);
        return $loan;
    }
}
