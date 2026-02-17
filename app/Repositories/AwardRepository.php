<?php

namespace App\Repositories;

use App\Models\Award;

class AwardRepository
{
    public function findByAboutId(int $aboutId): ?Award
    {
        return Award::with([
            'translations',
            'images' => fn($q) => $q->orderBy('sort_order'),
        ])->where('about_id', $aboutId)->first();
    }

    public function findById(int $id): ?Award
    {
        return Award::with([
            'translations',
            'images' => fn($q) => $q->orderBy('sort_order'),
        ])->find($id);
    }

    public function create(array $data): Award
    {
        return Award::create($data);
    }

    public function update(Award $award, array $data): bool
    {
        return $award->update($data);
    }

    public function createTranslation(int $awardId, array $data): void
    {
        Award::find($awardId)->translations()->updateOrCreate(
            ['lang_code' => $data['lang_code']],
            $data
        );
    }

    public function createImage(int $awardId, array $data): void
    {
        Award::find($awardId)->images()->create($data);
    }
}
