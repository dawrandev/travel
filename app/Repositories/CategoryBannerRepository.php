<?php

namespace App\Repositories;

use App\Models\CategoryBanner;

class CategoryBannerRepository
{
    public function getActive(): ?CategoryBanner
    {
        return CategoryBanner::with(['translations', 'images' => fn($q) => $q->orderBy('sort_order')])->where('is_active', true)->first();
    }

    public function getFirst(): ?CategoryBanner
    {
        return CategoryBanner::with(['translations', 'images' => fn($q) => $q->orderBy('sort_order')])->first();
    }

    public function findById(int $id): ?CategoryBanner
    {
        return CategoryBanner::with(['translations', 'images' => fn($q) => $q->orderBy('sort_order')])->find($id);
    }

    public function create(array $data): CategoryBanner
    {
        return CategoryBanner::create($data);
    }

    public function update(CategoryBanner $banner, array $data): bool
    {
        return $banner->update($data);
    }

    public function createTranslation(int $bannerId, array $data): void
    {
        CategoryBanner::find($bannerId)->translations()->updateOrCreate(
            ['lang_code' => $data['lang_code']],
            $data
        );
    }

    public function createImage(int $bannerId, array $data): void
    {
        CategoryBanner::find($bannerId)->images()->create($data);
    }
}
