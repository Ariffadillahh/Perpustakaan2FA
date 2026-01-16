<?php

namespace App\Http\Controllers;

use App\Http\Requests\Loan\LoanRequest;
use App\Models\Loan;
use App\Services\LoanService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoansController extends Controller
{

    protected $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        if (in_array($user->role_id, [1, 2])) {
            $search = $request->input('search');
            $limit = 10;
            $loans = $this->loanService->getAllLoans($search, $limit);
            return view('dashboard.loans.index', compact('loans'));
        }

        $loans = $this->loanService->getUserLoans($user->id);
        return view('users.loans.index', compact('loans'));
    }

    public function store(LoanRequest $request)
    {
        $result = $this->loanService->createLoan([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'loan_date' => now(),
            'return_date' => $request->return_date,
        ]);

        if (!$result['status']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->route('loans.index')->with('success', 'Buku berhasil dipinjam!');
    }

    public function updateStatus(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);

        $finalFine = $loan->current_fine;

        $loan->update([
            'status'      => 'returned',
            'fine_amount' => $finalFine,
            'returned_at' => now(),
        ]);

        $loan->book->increment('stock');

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan.');
    }
}
