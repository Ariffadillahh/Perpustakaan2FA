<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use App\Services\AuthService;
use App\Services\BookService;
use App\Services\CategoryService;

class DashboardController extends Controller
{
    protected $bookService;
    protected $authService;
    protected $categoryService;

    public function __construct(
        BookService $bookService,
        AuthService $authService,
        CategoryService $categoryService
    ) {
        $this->bookService = $bookService;
        $this->authService = $authService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $totalBooks =   Book::count();
        $totalMembers = User::where('role_id', 3)->count();
        $activeLoans = Loan::where('status', 'borrowed')->count();

        $categories = $this->categoryService->getAllCategories();

        return view('dashboard.dashboard', compact(
            'totalBooks',
            'totalMembers',
            'activeLoans',
            'categories'
        ));
    }
}
