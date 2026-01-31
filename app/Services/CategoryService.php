<?php

namespace App\Services;

use App\Models\Language;
use App\Repositories\CategoryRepository;

class CategoryService
{
    public function __construct(
        protected CategoryRepository $categoryRepository
    ) {}

    public function getAll()
    {
        return $this->categoryRepository->getAll();
    }

    public function getAllByLanguage(string $langCode)
    {
        $categories = $this->categoryRepository->getAll();

        return $categories->map(function ($category) use ($langCode) {
            $translation = $category->translations->where('lang_code', $langCode)->first();
            return [
                'id' => $category->id,
                'name' => $translation->name ?? 'N/A',
                'sort_order' => $category->sort_order,
                'is_active' => $category->is_active
            ];
        });
    }

    public function findById(int $id)
    {
        return $this->categoryRepository->findById($id);
    }

    public function create(array $data)
    {
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $category = $this->categoryRepository->create($data);

        // Create translations for all languages
        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->categoryRepository->createTranslation($category->id, [
                'name' => $data['name_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $category;
    }

    public function update(int $id, array $data)
    {
        $category = $this->categoryRepository->findById($id);

        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $this->categoryRepository->update($category, $data);

        // Delete old translations and create new ones
        $category->translations()->delete();

        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->categoryRepository->createTranslation($category->id, [
                'name' => $data['name_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $category;
    }

    public function delete(int $id)
    {
        $category = $this->categoryRepository->findById($id);
        return $this->categoryRepository->delete($category);
    }
}
