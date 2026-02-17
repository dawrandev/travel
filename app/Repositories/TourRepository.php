<?php

namespace App\Repositories;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TourRepository
{
    public function getAll(): Collection
    {
        return Tour::with(['translations', 'category.translations', 'images', 'features.translations'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getAllByCategory(?int $categoryId = null): LengthAwarePaginator
    {
        $query = Tour::with(['translations', 'category.translations', 'images', 'features.translations'])
            ->where('is_active', true);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        return $query->orderBy('created_at', 'desc')->paginate(12);
    }

    public function findById(int $id): ?Tour
    {
        return Tour::with(['translations', 'category.translations', 'images', 'itineraries.translations', 'features.translations', 'accommodations.translations'])
            ->find($id);
    }

    public function create(array $data): Tour
    {
        return Tour::create($data);
    }

    public function update(Tour $tour, array $data): bool
    {
        return $tour->update($data);
    }

    public function delete(Tour $tour): bool
    {
        return $tour->delete();
    }

    public function createTranslation(int $tourId, array $data): void
    {
        Tour::find($tourId)->translations()->updateOrCreate(
            ['lang_code' => $data['lang_code']],
            $data
        );
    }

    public function createImage(int $tourId, array $data): void
    {
        Tour::find($tourId)->images()->create($data);
    }

    public function createItinerary(int $tourId, array $data): int
    {
        $itinerary = Tour::find($tourId)->itineraries()->create($data);
        return $itinerary->id;
    }

    public function syncFeatures(int $tourId, array $featureIds): void
    {
        Tour::find($tourId)->features()->sync($featureIds);
    }

    public function syncFeaturesWithPivot(int $tourId, array $featuresData): void
    {
        Tour::find($tourId)->features()->sync($featuresData);
    }

    public function createAccommodation(int $tourId, array $data): int
    {
        $accommodation = Tour::find($tourId)->accommodations()->create($data);
        return $accommodation->id;
    }

    public function createAccommodationTranslation(int $accommodationId, array $data): void
    {
        \App\Models\TourAccommodation::find($accommodationId)->translations()->create($data);
    }
}
