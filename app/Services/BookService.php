<?php

namespace App\Services;

use App\Repositories\BookRepository;
use Illuminate\Support\Facades\Storage;

class BookService
{
    protected $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function getAllBooks($limit, $search = null)
    {
        return $this->bookRepository->getPaginated($limit, $search);
    }

    public function getCategories()
    {
        return $this->bookRepository->getAllCategories();
    }

    public function getBookById($id)
    {
        return $this->bookRepository->find($id);
    }

    public function createBook(array $data, $thumbnailFile)
    {
        // Logic upload Gambar
        if ($thumbnailFile) {
            $path = $thumbnailFile->store('books', 'public');
            $data['thumbnail'] = $path;
        }

        return $this->bookRepository->create($data);
    }

    public function updateBook($id, array $data, $thumbnailFile = null)
    {
        $book = $this->bookRepository->find($id);

        // Logic Ganti Gambar
        if ($thumbnailFile) {

            // Hapus gambar lama jika ada
            if ($book->thumbnail && Storage::disk('public')->exists($book->thumbnail)) {
                Storage::disk('public')->delete($book->thumbnail);
            }

            // Upload baru
            $path = $thumbnailFile->store('books', 'public');
            $data['thumbnail'] = $path;
        }

        return $this->bookRepository->update($id, $data);
    }

    public function deleteBook($id)
    {
        $book = $this->bookRepository->find($id);

        // Hapus file gambar saat data dihapus
        if ($book->thumbnail && Storage::disk('public')->exists($book->thumbnail)) {
            Storage::disk('public')->delete($book->thumbnail);
        }

        return $this->bookRepository->delete($id);
    }
}
