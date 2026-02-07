<?php

namespace App\Services;

use App\Models\Language;
use App\Repositories\FaqCategoryRepository;

class FaqCategoryService
{
    public function __construct(
        protected FaqCategoryRepository $faqCategoryRepository
    ) {}

    public function getAll()
    {
        return $this->faqCategoryRepository->getAll();
    }

    public function getAllByLanguage(string $langCode)
    {
        $categories = $this->faqCategoryRepository->getAll();

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
        return $this->faqCategoryRepository->findById($id);
    }

    public function create(array $data)
    {
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $category = $this->faqCategoryRepository->create($data);

        // Create translations for all languages
        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->faqCategoryRepository->createTranslation($category->id, [
                'name' => $data['name_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $category;
    }

    public function update(int $id, array $data)
    {
        $category = $this->faqCategoryRepository->findById($id);

        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $this->faqCategoryRepository->update($category, $data);

        // Delete old translations and create new ones
        $this->faqCategoryRepository->deleteTranslations($category->id);

        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->faqCategoryRepository->createTranslation($category->id, [
                'name' => $data['name_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $category;
    }

    public function delete(int $id)
    {
        $category = $this->faqCategoryRepository->findById($id);
        return $this->faqCategoryRepository->delete($category);
    }
}
