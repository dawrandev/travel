<?php

namespace App\Repositories;

use App\Models\About;
use Illuminate\Database\Eloquent\Collection;

class AboutRepository
{
    public function getAll(): Collection
    {
        return About::with(['translations', 'images'])->get();
    }

    public function findById(int $id): ?About
    {
        return About::with(['translations', 'images'])->find($id);
    }

    public function create(array $data): About
    {
        return About::create($data);
    }

    public function update(About $about, array $data): bool
    {
        return $about->update($data);
    }

    public function delete(About $about): bool
    {
        return $about->delete();
    }

    public function createTranslation(int $aboutId, array $data): void
    {
        About::find($aboutId)->translations()->updateOrCreate(
            ['lang_code' => $data['lang_code']],
            $data
        );
    }
}
