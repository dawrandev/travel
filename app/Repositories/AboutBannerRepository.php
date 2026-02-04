<?php

namespace App\Repositories;

use App\Models\AboutBanner;

class AboutBannerRepository
{
    public function getActive(): ?AboutBanner
    {
        return AboutBanner::with('translations')->where('is_active', true)->first();
    }

    public function getFirst(): ?AboutBanner
    {
        return AboutBanner::with('translations')->first();
    }

    public function findById(int $id): ?AboutBanner
    {
        return AboutBanner::with('translations')->find($id);
    }

    public function create(array $data): AboutBanner
    {
        return AboutBanner::create($data);
    }

    public function update(AboutBanner $banner, array $data): bool
    {
        return $banner->update($data);
    }

    public function createTranslation(int $bannerId, array $data): void
    {
        AboutBanner::find($bannerId)->translations()->updateOrCreate(
            ['lang_code' => $data['lang_code']],
            $data
        );
    }
}
