<?php

namespace App\Repositories;

use App\Models\ReviewBanner;

class ReviewBannerRepository
{
    public function getActive(): ?ReviewBanner
    {
        return ReviewBanner::with('translations')->where('is_active', true)->first();
    }

    public function getFirst(): ?ReviewBanner
    {
        return ReviewBanner::with('translations')->first();
    }

    public function findById(int $id): ?ReviewBanner
    {
        return ReviewBanner::with('translations')->find($id);
    }

    public function create(array $data): ReviewBanner
    {
        return ReviewBanner::create($data);
    }

    public function update(ReviewBanner $banner, array $data): bool
    {
        return $banner->update($data);
    }

    public function createTranslation(int $bannerId, array $data): void
    {
        ReviewBanner::find($bannerId)->translations()->updateOrCreate(
            ['lang_code' => $data['lang_code']],
            $data
        );
    }
}
