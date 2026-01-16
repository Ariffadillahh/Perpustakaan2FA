<?php

namespace App\Repositories;

use App\Models\Categories;

class CategoryRepository
{
    public function getAll()
    {
        return Categories::latest()->get();
    }

    public function findById($id)
    {
        return Categories::findOrFail($id);
    }

    public function create(array $data)
    {
        return Categories::create($data);
    }

    public function update($id, array $data)
    {
        $category = $this->findById($id);
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        $category = $this->findById($id);
        return $category->delete();
    }
}
