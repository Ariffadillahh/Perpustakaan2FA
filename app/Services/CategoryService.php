<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Support\Str;
use Exception;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAll();
    }

    public function createCategory(array $data)
    {
        $data['name'] = ucwords(strtolower($data['name']));

        return $this->categoryRepository->create($data);
    }

    public function updateCategory($id, array $data)
    {
        $data['name'] = ucwords(strtolower($data['name']));
        return $this->categoryRepository->update($id, $data);
    }

    public function deleteCategory($id)
    {
        return $this->categoryRepository->delete($id);
    }
}
