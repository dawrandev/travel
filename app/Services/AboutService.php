<?php

namespace App\Services;

use App\Models\Language;
use App\Repositories\AboutRepository;
use Illuminate\Support\Facades\Storage;

class AboutService
{
    public function __construct(
        protected AboutRepository $aboutRepository
    ) {}

    public function getAll()
    {
        return $this->aboutRepository->getAll();
    }

    public function getAllByLanguage(string $langCode)
    {
        $abouts = $this->aboutRepository->getAll();

        return $abouts->map(function ($about) use ($langCode) {
            $translation = $about->translations->where('lang_code', $langCode)->first();

            $award = null;
            if ($about->award) {
                $awardTranslation = $about->award->translations->where('lang_code', $langCode)->first();
                $awardImage = $about->award->images->sortBy('sort_order')->first();
                $award = [
                    'id' => $about->award->id,
                    'description' => $awardTranslation->description ?? null,
                    'image' => $awardImage?->image_path,
                    'is_active' => $about->award->is_active,
                ];
            }

            return [
                'id' => $about->id,
                'title' => $translation->title ?? 'N/A',
                'description' => $translation->description ?? 'N/A',
                'image' => $about->image,
                'is_active' => $about->is_active,
                'award' => $award,
            ];
        });
    }

    public function findById(int $id)
    {
        return $this->aboutRepository->findById($id);
    }

    public function create(array $data)
    {
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        $about = $this->aboutRepository->create($data);

        if (isset($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $index => $image) {
                $imagePath = $image->store('uploads', 'public');
                $this->aboutRepository->createImage($about->id, [
                    'image_path' => $imagePath,
                    'sort_order' => $index,
                ]);
            }
        }

        $languages = Language::where('is_active', true)->get();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->aboutRepository->createTranslation($about->id, [
                'title' => $data['title_' . $langCode] ?? '',
                'description' => $data['description_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $about;
    }

    public function update(int $id, array $data)
    {
        $about = $this->aboutRepository->findById($id);

        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        $this->aboutRepository->update($about, $data);

        if (isset($data['images']) && is_array($data['images']) && count($data['images']) > 0) {
            foreach ($about->images as $oldImage) {
                Storage::disk('public')->delete($oldImage->image_path);
            }
            $about->images()->delete();

            foreach ($data['images'] as $index => $image) {
                $imagePath = $image->store('uploads', 'public');
                $this->aboutRepository->createImage($about->id, [
                    'image_path' => $imagePath,
                    'sort_order' => $index,
                ]);
            }
        }

        $about->translations()->delete();
        $languages = Language::where('is_active', true)->get();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->aboutRepository->createTranslation($about->id, [
                'title' => $data['title_' . $langCode] ?? '',
                'description' => $data['description_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $about;
    }

    public function delete(int $id)
    {
        $about = $this->aboutRepository->findById($id);

        if ($about->image) {
            Storage::disk('public')->delete($about->image);
        }

        return $this->aboutRepository->delete($about);
    }
}
