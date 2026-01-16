<?php

namespace App\Services;

use App\Models\Loan;
use App\Repositories\LoanRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoanService
{
    protected $loanRepo;

    public function __construct(LoanRepository $loanRepo)
    {
        $this->loanRepo = $loanRepo;
    }

    public function getAllLoans($search = null, $limit = 10)
    {
        return $this->loanRepo->all($search, $limit);
    }

    public function getUserLoans($userId)
    {
        return $this->loanRepo->getByUserId($userId);
    }

    public function createLoan($data)
    {
        $user = Auth::user();

        // Cek apakah sedang meminjam buku yang sama dan belum balik
        $isBorrowing = Loan::where('user_id', $user->id)
            ->where('book_id', $data['book_id'])
            ->where('status', 'borrowed')
            ->exists();

        if ($isBorrowing) {
            return [
                'status' => false,
                'message' => 'Anda sudah meminjam buku ini dan belum mengembalikannya!'
            ];
        }

        $loan = $this->loanRepo->create($data);
        $loan->book->decrement('stock');

        return ['status' => true, 'loan' => $loan];
    }

    public function processReturn($id)
    {
        $loan = $this->loanRepo->find($id);

        $fineAmount = $loan->current_fine;

        $this->loanRepo->update($id, [
            'status'      => 'returned',
            'returned_at' => Carbon::now(),
            'fine_amount' => $fineAmount 
        ]);

        $loan->book->increment('stock');

        return ['fine' => $fineAmount];
    }
}
