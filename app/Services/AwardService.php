<?php

namespace App\Services;

use App\Models\Award;
use App\Models\Language;
use App\Repositories\AwardRepository;
use Illuminate\Support\Facades\Storage;

class AwardService
{
    public function __construct(
        private AwardRepository $awardRepository
    ) {}

    public function findByAboutId(int $aboutId): ?Award
    {
        return $this->awardRepository->findByAboutId($aboutId);
    }

    public function findById(int $id): ?Award
    {
        return $this->awardRepository->findById($id);
    }

    public function create(int $aboutId, array $data): Award
    {
        $award = $this->awardRepository->create([
            'about_id' => $aboutId,
            'is_active' => isset($data['is_active']) ? 1 : 0,
        ]);

        if (isset($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $index => $image) {
                $imagePath = $image->store('uploads', 'public');
                $this->awardRepository->createImage($award->id, [
                    'image_path' => $imagePath,
                    'sort_order' => $index,
                ]);
            }
        }

        $languages = Language::where('is_active', true)->get();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->awardRepository->createTranslation($award->id, [
                'description' => $data['description_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $award;
    }

    public function update(int $id, array $data): Award
    {
        $award = $this->awardRepository->findById($id);

        $this->awardRepository->update($award, [
            'is_active' => isset($data['is_active']) ? 1 : 0,
        ]);

        if (isset($data['images']) && is_array($data['images']) && count($data['images']) > 0) {
            foreach ($award->images as $oldImage) {
                Storage::disk('public')->delete($oldImage->image_path);
            }
            $award->images()->delete();

            foreach ($data['images'] as $index => $image) {
                $imagePath = $image->store('uploads', 'public');
                $this->awardRepository->createImage($award->id, [
                    'image_path' => $imagePath,
                    'sort_order' => $index,
                ]);
            }
        }

        $award->translations()->delete();
        $languages = Language::where('is_active', true)->get();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->awardRepository->createTranslation($award->id, [
                'description' => $data['description_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $award;
    }

    public function delete(int $id): bool
    {
        $award = $this->awardRepository->findById($id);

        foreach ($award->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        return $award->delete();
    }
}
