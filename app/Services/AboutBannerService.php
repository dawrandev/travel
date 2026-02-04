<?php

namespace App\Services;

use App\Models\Language;
use App\Repositories\AboutBannerRepository;
use Illuminate\Support\Facades\Storage;

class AboutBannerService
{
    public function __construct(
        private AboutBannerRepository $aboutBannerRepository
    ) {}

    public function getActive()
    {
        return $this->aboutBannerRepository->getActive();
    }

    public function getFirst()
    {
        return $this->aboutBannerRepository->getFirst();
    }

    public function findById(int $id)
    {
        return $this->aboutBannerRepository->findById($id);
    }

    public function create(array $data)
    {
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        if (isset($data['banner_image'])) {
            $data['image'] = $data['banner_image']->store('uploads', 'public');
            unset($data['banner_image']);
        }

        $banner = $this->aboutBannerRepository->create($data);

        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->aboutBannerRepository->createTranslation($banner->id, [
                'title' => $data['banner_title_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $banner;
    }

    public function update(int $id, array $data)
    {
        $banner = $this->aboutBannerRepository->findById($id);

        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        if (isset($data['banner_image'])) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $data['banner_image']->store('uploads', 'public');
            unset($data['banner_image']);
        }

        $this->aboutBannerRepository->update($banner, $data);

        $banner->translations()->delete();
        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->aboutBannerRepository->createTranslation($banner->id, [
                'title' => $data['banner_title_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $banner;
    }
}
