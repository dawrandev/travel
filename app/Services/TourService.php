<?php

namespace App\Services;

use App\Models\Language;
use App\Models\TourItineraryTranslation;
use App\Repositories\TourRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TourService
{
    public function __construct(
        protected TourRepository $tourRepository
    ) {}

    public function getAll()
    {
        return $this->tourRepository->getAll();
    }

    public function getAllByCategory(?int $categoryId = null)
    {
        return $this->tourRepository->getAllByCategory($categoryId);
    }

    public function findById(int $id)
    {
        return $this->tourRepository->findById($id);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Create tour
            $tourData = [
                'category_id' => $data['category_id'],
                'price' => $data['price'],
                'duration_days' => $data['duration_days'],
                'duration_nights' => $data['duration_nights'] ?? 0,
                'min_age' => $data['min_age'],
                'max_people' => $data['max_people'],
                'phone' => $data['phone'],
                'is_active' => isset($data['is_active']) ? 1 : 0,
            ];

            $tour = $this->tourRepository->create($tourData);

            // Create translations
            $this->createTranslations($tour->id, $data);

            // Create images
            if (isset($data['images']) && is_array($data['images'])) {
                $this->createImages($tour->id, $data['images'], $data['main_image'] ?? null);
            }

            // Create itineraries
            if (isset($data['itineraries']) && is_array($data['itineraries'])) {
                $this->createItineraries($tour->id, $data['itineraries']);
            }

            // Store gif_map if uploaded
            if (isset($data['gif_map']) && $data['gif_map'] instanceof \Illuminate\Http\UploadedFile) {
                $path = $data['gif_map']->store('uploads', 'public');
                $tour->update(['gif_map' => $path]);
            }

            // Sync features (inclusions)
            $this->syncFeaturesFromRequest($tour->id, $data);

            return $tour;
        });
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $tour = $this->tourRepository->findById($id);

            // Update tour
            $tourData = [
                'category_id' => $data['category_id'],
                'price' => $data['price'],
                'duration_days' => $data['duration_days'],
                'duration_nights' => $data['duration_nights'] ?? 0,
                'min_age' => $data['min_age'],
                'max_people' => $data['max_people'],
                'phone' => $data['phone'],
                'is_active' => isset($data['is_active']) ? 1 : 0,
            ];

            $this->tourRepository->update($tour, $tourData);

            // Update translations
            $tour->translations()->delete();
            $this->createTranslations($tour->id, $data);

            // Update images (only if new images uploaded)
            if (isset($data['images']) && is_array($data['images']) && count($data['images']) > 0) {
                // Check if actual files were uploaded
                $hasNewImages = false;
                foreach ($data['images'] as $image) {
                    if ($image && is_object($image) && method_exists($image, 'isValid') && $image->isValid()) {
                        $hasNewImages = true;
                        break;
                    }
                }

                if ($hasNewImages) {
                    // Delete old images
                    foreach ($tour->images as $image) {
                        if (Storage::disk('public')->exists($image->image_path)) {
                            Storage::disk('public')->delete($image->image_path);
                        }
                    }
                    $tour->images()->delete();

                    // Create new images
                    $this->createImages($tour->id, $data['images'], $data['main_image'] ?? null);
                }
            } else {
                // No new images uploaded, but check if main image changed
                if (isset($data['main_image_id'])) {
                    // Reset all images to not main
                    $tour->images()->update(['is_main' => false]);
                    // Set selected image as main
                    $tour->images()->where('id', $data['main_image_id'])->update(['is_main' => true]);
                }
            }

            // Update itineraries
            if (isset($data['itineraries']) && is_array($data['itineraries'])) {
                // Delete old itineraries and translations
                foreach ($tour->itineraries as $itinerary) {
                    $itinerary->translations()->delete();
                }
                $tour->itineraries()->delete();

                // Create new itineraries
                $this->createItineraries($tour->id, $data['itineraries']);
            }

            // Update gif_map if new file uploaded
            if (isset($data['gif_map']) && $data['gif_map'] instanceof \Illuminate\Http\UploadedFile) {
                if ($tour->gif_map && Storage::disk('public')->exists($tour->gif_map)) {
                    Storage::disk('public')->delete($tour->gif_map);
                }
                $path = $data['gif_map']->store('uploads', 'public');
                $tour->update(['gif_map' => $path]);
            }

            // Update features (inclusions)
            $this->syncFeaturesFromRequest($tour->id, $data);

            return $tour;
        });
    }

    public function delete(int $id)
    {
        $tour = $this->tourRepository->findById($id);

        // Delete images from storage
        foreach ($tour->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }

        // Delete gif_map from storage
        if ($tour->gif_map && Storage::disk('public')->exists($tour->gif_map)) {
            Storage::disk('public')->delete($tour->gif_map);
        }

        return $this->tourRepository->delete($tour);
    }

    protected function createTranslations(int $tourId, array $data)
    {
        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->tourRepository->createTranslation($tourId, [
                'title' => $data['title_' . $langCode] ?? '',
                'slogan' => $data['slogan_' . $langCode] ?? '',
                'description' => $data['description_' . $langCode] ?? '',
                'routes' => $data['routes_' . $langCode] ?? '',
                'important_info' => $data['important_info_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }
    }

    protected function createImages(int $tourId, array $images, ?int $mainImageIndex = null)
    {
        foreach ($images as $index => $image) {
            if ($image && $image->isValid()) {
                $path = $image->store('uploads', 'public');
                $this->tourRepository->createImage($tourId, [
                    'image_path' => $path,
                    'is_main' => $mainImageIndex !== null && $mainImageIndex == $index,
                ]);
            }
        }
    }

    protected function createItineraries(int $tourId, array $itineraries)
    {
        $languages = Language::all();

        foreach ($itineraries as $itinerary) {
            // Skip if day_number or event_time is missing
            if (!isset($itinerary['day_number']) || !isset($itinerary['event_time'])) {
                continue;
            }

            $itineraryId = $this->tourRepository->createItinerary($tourId, [
                'day_number' => $itinerary['day_number'],
                'event_time' => $itinerary['event_time'],
            ]);

            // Create translations for this itinerary
            foreach ($languages as $language) {
                $langCode = $language->code;
                TourItineraryTranslation::create([
                    'tour_itenerary_id' => $itineraryId,
                    'lang_code' => $langCode,
                    'activity_title' => $itinerary['activity_title_' . $langCode] ?? '',
                    'activity_description' => $itinerary['activity_description_' . $langCode] ?? '',
                ]);
            }
        }
    }

    protected function syncFeaturesFromRequest(int $tourId, array $data)
    {
        $featuresData = [];

        // Extract all feature_* fields from request
        foreach ($data as $key => $value) {
            if (str_starts_with($key, 'feature_')) {
                $featureId = (int) str_replace('feature_', '', $key);

                // Only sync if a selection was made (included or excluded)
                if (in_array($value, ['included', 'excluded'])) {
                    $featuresData[$featureId] = [
                        'is_included' => $value === 'included'
                    ];
                }
            }
        }

        // Log for debugging
        Log::info('Sync Features Data', [
            'tour_id' => $tourId,
            'features_data' => $featuresData,
            'all_data_keys' => array_keys($data)
        ]);

        // Sync features with pivot data
        $this->tourRepository->syncFeaturesWithPivot($tourId, $featuresData);
    }
}
