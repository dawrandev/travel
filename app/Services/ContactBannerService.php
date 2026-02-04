<?php

namespace App\Services;

use App\Models\Language;
use App\Repositories\ContactBannerRepository;
use Illuminate\Support\Facades\Storage;

class ContactBannerService
{
    public function __construct(
        private ContactBannerRepository $contactBannerRepository
    ) {}

    public function getActive()
    {
        return $this->contactBannerRepository->getActive();
    }

    public function getFirst()
    {
        return $this->contactBannerRepository->getFirst();
    }

    public function findById(int $id)
    {
        return $this->contactBannerRepository->findById($id);
    }

    public function create(array $data)
    {
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        if (isset($data['banner_image'])) {
            $data['image'] = $data['banner_image']->store('uploads', 'public');
            unset($data['banner_image']);
        }

        $banner = $this->contactBannerRepository->create($data);

        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->contactBannerRepository->createTranslation($banner->id, [
                'title' => $data['banner_title_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $banner;
    }

    public function update(int $id, array $data)
    {
        $banner = $this->contactBannerRepository->findById($id);

        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        if (isset($data['banner_image'])) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $data['banner_image']->store('uploads', 'public');
            unset($data['banner_image']);
        }

        $this->contactBannerRepository->update($banner, $data);

        $banner->translations()->delete();
        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->contactBannerRepository->createTranslation($banner->id, [
                'title' => $data['banner_title_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $banner;
    }
}
