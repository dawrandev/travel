<?php

namespace App\Repositories;

use App\Models\FaqCategory;
use App\Models\FaqCategoryTranslation;

class FaqCategoryRepository
{
    public function getAll()
    {
        return FaqCategory::with('translations')
            ->orderBy('sort_order')
            ->get();
    }

    public function findById($id)
    {
        return FaqCategory::with('translations')->find($id);
    }

    public function create($data)
    {
        return FaqCategory::create($data);
    }

    public function update($category, $data)
    {
        $category->update($data);
        return $category;
    }

    public function delete($category)
    {
        return $category->delete();
    }

    public function createTranslation($categoryId, $data)
    {
        return FaqCategoryTranslation::create([
            'faq_category_id' => $categoryId,
            'lang_code' => $data['lang_code'],
            'name' => $data['name'],
        ]);
    }

    public function deleteTranslations($categoryId)
    {
        return FaqCategoryTranslation::where('faq_category_id', $categoryId)->delete();
    }
}
