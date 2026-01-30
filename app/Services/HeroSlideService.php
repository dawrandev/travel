<?php

namespace App\Services;

use App\Models\Language;
use App\Repositories\HeroSlideRepository;
use Illuminate\Support\Facades\Storage;

class HeroSlideService
{
    public function __construct(
        protected HeroSlideRepository $heroSlideRepository
    ) {}

    public function getAll()
    {
        return $this->heroSlideRepository->getAll();
    }

    public function getAllByLanguage(string $langCode)
    {
        $slides = $this->heroSlideRepository->getAll();

        return $slides->map(function ($slide) use ($langCode) {
            $translation = $slide->translations->where('lang_code', $langCode)->first();
            return [
                'id' => $slide->id,
                'title' => $translation->title ?? 'N/A',
                'subtitle' => $translation->subtitle ?? 'N/A',
                'image_path' => $slide->image_path,
                'sort_order' => $slide->sort_order,
                'is_active' => $slide->is_active
            ];
        });
    }

    public function findById(int $id)
    {
        return $this->heroSlideRepository->findById($id);
    }

    public function create(array $data)
    {
        if (isset($data['image'])) {
            $data['image_path'] = $data['image']->store('hero-slides', 'public');
            unset($data['image']);
        }

        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $heroSlide = $this->heroSlideRepository->create($data);

        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->heroSlideRepository->createTranslation($heroSlide->id, [
                'title' => $data['title_' . $langCode] ?? '',
                'subtitle' => $data['subtitle_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $heroSlide;
    }

    public function update(int $id, array $data)
    {
        $heroSlide = $this->heroSlideRepository->findById($id);

        if (isset($data['image'])) {
            if ($heroSlide->image_path) {
                Storage::disk('public')->delete($heroSlide->image_path);
            }
            $data['image_path'] = $data['image']->store('hero-slides', 'public');
            unset($data['image']);
        }

        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $this->heroSlideRepository->update($heroSlide, $data);

        $heroSlide->translations()->delete();

        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->heroSlideRepository->createTranslation($heroSlide->id, [
                'title' => $data['title_' . $langCode] ?? '',
                'subtitle' => $data['subtitle_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $heroSlide;
    }

    public function delete(int $id)
    {
        $heroSlide = $this->heroSlideRepository->findById($id);

        if ($heroSlide->image_path) {
            Storage::disk('public')->delete($heroSlide->image_path);
        }

        return $this->heroSlideRepository->delete($heroSlide);
    }
}
