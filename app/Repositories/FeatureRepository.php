<?php

namespace App\Repositories;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FeatureRepository
{
    public function getAll(): LengthAwarePaginator
    {
        return Feature::with('translations')->paginate(15);
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
