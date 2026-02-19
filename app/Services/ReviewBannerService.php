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

        // Create banner without images
        $banner = $this->reviewBannerRepository->create(['is_active' => $data['is_active']]);

        // Handle 3 images
        if (isset($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $index => $image) {
                $imagePath = $image->store('uploads', 'public');
                $this->reviewBannerRepository->createImage($banner->id, [
                    'image_path' => $imagePath,
                    'sort_order' => $index,
                ]);
            }
        }

        $languages = Language::where('is_active', true)->get();
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

        // If new images uploaded
        if (isset($data['images']) && is_array($data['images']) && count($data['images']) > 0) {
            // Delete old images from storage
            foreach ($banner->images as $oldImage) {
                Storage::disk('public')->delete($oldImage->image_path);
            }
            // Delete image records
            $banner->images()->delete();

            // Add new images
            foreach ($data['images'] as $index => $image) {
                $imagePath = $image->store('uploads', 'public');
                $this->reviewBannerRepository->createImage($banner->id, [
                    'image_path' => $imagePath,
                    'sort_order' => $index,
                ]);
            }
        }

        $this->reviewBannerRepository->update($banner, ['is_active' => $data['is_active']]);

        $banner->translations()->delete();
        $languages = Language::where('is_active', true)->get();
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
