<?php

namespace App\Repositories;

use App\Models\HeroSlide;
use Illuminate\Database\Eloquent\Collection;

class HeroSlideRepository
{
    public function getAll(): Collection
    {
        return HeroSlide::with('translations')->orderBy('sort_order')->get();
    }

    public function findById(int $id): ?HeroSlide
    {
        return HeroSlide::with('translations')->find($id);
    }

    public function create(array $data): HeroSlide
    {
        return HeroSlide::create($data);
    }

    public function update(HeroSlide $heroSlide, array $data): bool
    {
        return $heroSlide->update($data);
    }

    public function delete(HeroSlide $heroSlide): bool
    {
        return $heroSlide->delete();
    }

    public function createTranslation(int $heroSlideId, array $data): void
    {
        HeroSlide::find($heroSlideId)->translations()->updateOrCreate(
            ['lang_code' => $data['lang_code']],
            $data
        );
    }
}
