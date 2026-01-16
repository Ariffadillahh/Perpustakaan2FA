<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Services\BookService;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index(Request $request)
    {
        $limit = 8;

        $search = $request->input('search');

        $books = $this->bookService->getAllBooks($limit, $search);

        return view('dashboard.books.index', compact('books'));
    }

    public function show($id)
    {
        $book = $this->bookService->getBookById($id);
        return view('users.books.show', compact('book'));
    }

    public function create()
    {
        $categories = $this->bookService->getCategories();
        return view('dashboard.books.create', compact('categories'));
    }

    public function store(StoreBookRequest $request)
    {
        $this->bookService->createBook(
            $request->validated(),
            $request->file('thumbnail')
        );

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $book = $this->bookService->getBookById($id);
        $categories = $this->bookService->getCategories();

        return view('dashboard.books.edit', compact('book', 'categories'));
    }

    public function update(UpdateBookRequest $request, $id)
    {
        $this->bookService->updateBook(
            $id,
            $request->validated(),
            $request->file('thumbnail')
        );

        return redirect()->route('books.index')->with('success', 'Data buku diperbarui!');
    }

    public function destroy($id)
    {
        $this->bookService->deleteBook($id);
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
