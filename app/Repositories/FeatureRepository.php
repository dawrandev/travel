<?php

namespace App\Repositories;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Collection;

class FeatureRepository
{
    public function getAll(): Collection
    {
        return Feature::with('translations')->get();
    }

    public function findById(int $id): ?Feature
    {
        return Feature::with('translations')->find($id);
    }

    public function create(array $data): Feature
    {
        return Feature::create($data);
    }

    public function update(Feature $feature, array $data): bool
    {
        return $feature->update($data);
    }

    public function delete(Feature $feature): bool
    {
        return $feature->delete();
    }

    public function createTranslation(int $featureId, array $data): void
    {
        Feature::find($featureId)->translations()->updateOrCreate(
            ['lang_code' => $data['lang_code']],
            $data
        );
    }
}
