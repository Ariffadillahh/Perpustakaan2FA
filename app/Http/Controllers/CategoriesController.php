<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ], [
            'name.unique' => 'Nama kategori sudah ada.'
        ]);

        try {
            $this->categoryService->createCategory($request->only('name'));
            return back()->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambah kategori: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id
        ]);

        try {
            $this->categoryService->updateCategory($id, $request->only('name'));
            return back()->with('success', 'Kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update kategori: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->categoryService->deleteCategory($id);
            return back()->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
}
