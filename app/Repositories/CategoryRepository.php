<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    public function getAll(): Collection
    {
        return Category::with('translations')->orderBy('sort_order')->get();
    }

    public function findById(int $id): ?Category
    {
        return Category::with('translations')->find($id);
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data): bool
    {
        return $category->update($data);
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }

    public function createTranslation(int $categoryId, array $data): void
    {
        Category::find($categoryId)->translations()->updateOrCreate(
            ['lang_code' => $data['lang_code']],
            $data
        );
    }
}
