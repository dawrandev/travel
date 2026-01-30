<?php

namespace App\Services;

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

        $this->heroSlideRepository->createTranslation($heroSlide->id, [
            'title' => $data['title'],
            'subtitle' => $data['subtitle'],
            'lang_code' => 'ru',
        ]);

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

        $this->heroSlideRepository->createTranslation($heroSlide->id, [
            'title' => $data['title'],
            'subtitle' => $data['subtitle'],
            'lang_code' => 'ru',
        ]);

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
