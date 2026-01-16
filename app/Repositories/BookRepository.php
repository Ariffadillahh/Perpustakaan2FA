<?php

namespace App\Repositories;

use App\Models\Book;
use App\Models\Categories;

class BookRepository
{
    public function getPaginated($perPage = 10, $search = null)
    {
        $query = Book::with('category')->latest();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%'); 
            });
        }

        return $query->paginate($perPage);
    }

    public function getAllCategories()
    {
        return Categories::all();
    }

    public function find($id)
    {
        return Book::findOrFail($id);
    }

    public function create(array $data)
    {
        return Book::create($data);
    }

    public function update($id, array $data)
    {
        $book = $this->find($id);
        $book->update($data);
        return $book;
    }

    public function delete($id)
    {
        $book = $this->find($id);
        $book->delete();
        return $book;
    }
}
