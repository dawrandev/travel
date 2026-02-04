<?php

namespace App\Services;

use App\Models\Language;
use App\Repositories\ReviewBannerRepository;
use Illuminate\Support\Facades\Storage;

class ReviewBannerService
{
    public function __construct(
        private ReviewBannerRepository $reviewBannerRepository
    ) {}

    public function getActive()
    {
        return $this->reviewBannerRepository->getActive();
    }

    public function getFirst()
    {
        return $this->reviewBannerRepository->getFirst();
    }

    public function findById(int $id)
    {
        return $this->reviewBannerRepository->findById($id);
    }

    public function create(array $data)
    {
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        if (isset($data['banner_image'])) {
            $data['image'] = $data['banner_image']->store('uploads', 'public');
            unset($data['banner_image']);
        }

        $banner = $this->reviewBannerRepository->create($data);

        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->reviewBannerRepository->createTranslation($banner->id, [
                'title' => $data['banner_title_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $banner;
    }

    public function update(int $id, array $data)
    {
        $banner = $this->reviewBannerRepository->findById($id);

        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        if (isset($data['banner_image'])) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $data['banner_image']->store('uploads', 'public');
            unset($data['banner_image']);
        }

        $this->reviewBannerRepository->update($banner, $data);

        $banner->translations()->delete();
        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->reviewBannerRepository->createTranslation($banner->id, [
                'title' => $data['banner_title_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $banner;
    }
}
