<?php

namespace App\Http\Controllers;

use App\Http\Requests\TourRequest;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Language;
use App\Services\TourService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TourController extends Controller
{
    public function __construct(
        protected TourService $tourService
    ) {}

    public function index(Request $request): View
    {
        $categoryId = $request->get('category_id');
        $tours = $this->tourService->getAllByCategory($categoryId);
        $categories = Category::with('translations')->where('is_active', true)->get();
        $features = Feature::with('translations')->get();
        $languages = Language::all();

        return view('pages.tours.index', compact('tours', 'categories', 'features', 'languages'));
    }

    public function show(int $id): JsonResponse
    {
        $tour = $this->tourService->findById($id);

        return response()->json([
            'success' => true,
            'tour' => $tour
        ]);
    }

    public function getTranslations(int $id): JsonResponse
    {
        $tour = $this->tourService->findById($id);
        $translations = [];

        foreach ($tour->translations as $translation) {
            $translations[$translation->lang_code] = [
                'title' => $translation->title,
                'slogan' => $translation->slogan,
                'description' => $translation->description,
                'routes' => $translation->routes,
                'important_info' => $translation->important_info,
            ];
        }

        // Get itineraries with translations
        $itineraries = [];
        foreach ($tour->itineraries as $itinerary) {
            $itineraryTranslations = [];
            foreach ($itinerary->translations as $trans) {
                $itineraryTranslations[$trans->lang_code] = [
                    'activity_title' => $trans->activity_title,
                    'activity_description' => $trans->activity_description,
                ];
            }

            $itineraries[] = [
                'id' => $itinerary->id,
                'day_number' => $itinerary->day_number,
                'event_time' => $itinerary->event_time,
                'translations' => $itineraryTranslations,
            ];
        }

        // Get features with inclusion status
        $features = [];
        foreach ($tour->features as $feature) {
            $features[$feature->id] = $feature->pivot->is_included ? 'included' : 'excluded';
        }

        return response()->json([
            'success' => true,
            'tour' => [
                'id' => $tour->id,
                'category_id' => $tour->category_id,
                'price' => $tour->price,
                'duration_days' => $tour->duration_days,
                'duration_nights' => $tour->duration_nights,
                'min_age' => $tour->min_age,
                'max_people' => $tour->max_people,
                'phone' => $tour->phone,
                'is_active' => $tour->is_active,
            ],
            'translations' => $translations,
            'itineraries' => $itineraries,
            'features' => $features,
            'images' => $tour->images,
        ]);
    }

    public function store(TourRequest $request): RedirectResponse
    {
        // Merge validated data with feature fields
        $data = $request->validated();
        $allData = $request->all();

        // Add feature fields to data
        foreach ($allData as $key => $value) {
            if (str_starts_with($key, 'feature_')) {
                $data[$key] = $value;
            }
        }

        $this->tourService->create($data);
        return redirect()->route('tours.index')->with('success', 'Тур успешно создан');
    }

    public function update(TourRequest $request, int $id): RedirectResponse
    {
        // Merge validated data with feature fields
        $data = $request->validated();
        $allData = $request->all();

        // Add feature fields to data
        foreach ($allData as $key => $value) {
            if (str_starts_with($key, 'feature_')) {
                $data[$key] = $value;
            }
        }

        // Also add main_image_id if present
        if ($request->has('main_image_id')) {
            $data['main_image_id'] = $request->input('main_image_id');
        }

        $this->tourService->update($id, $data);
        return redirect()->route('tours.index')->with('success', 'Тур успешно обновлен');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->tourService->delete($id);
        return redirect()->route('tours.index')->with('success', 'Тур успешно удален');
    }
}
