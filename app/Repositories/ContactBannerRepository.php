<?php

namespace App\Repositories;

use App\Models\ContactBanner;

class ContactBannerRepository
{
    public function getActive(): ?ContactBanner
    {
        return ContactBanner::with('translations')->where('is_active', true)->first();
    }

    public function getFirst(): ?ContactBanner
    {
        return ContactBanner::with('translations')->first();
    }

    public function findById(int $id): ?ContactBanner
    {
        return ContactBanner::with('translations')->find($id);
    }

    public function create(array $data): ContactBanner
    {
        return ContactBanner::create($data);
    }

    public function update(ContactBanner $banner, array $data): bool
    {
        return $banner->update($data);
    }

    public function createTranslation(int $bannerId, array $data): void
    {
        ContactBanner::find($bannerId)->translations()->updateOrCreate(
            ['lang_code' => $data['lang_code']],
            $data
        );
    }
}
