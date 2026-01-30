<?php

namespace App\Http\Controllers;

use App\Http\Requests\HeroSlideRequest;
use App\Models\Language;
use App\Services\HeroSlideService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    public function __construct(
        protected HeroSlideService $heroSlideService
    ) {}

    public function index(): View
    {
        $heroSlides = $this->heroSlideService->getAll();
        $languages = Language::all();
        return view('pages.hero-slides.index', compact('heroSlides', 'languages'));
    }

    public function filter(Request $request): JsonResponse
    {
        $langCode = $request->get('lang_code', 'en');
        $slides = $this->heroSlideService->getAllByLanguage($langCode);

        return response()->json([
            'success' => true,
            'data' => $slides
        ]);
    }

    public function getTranslations(int $id): JsonResponse
    {
        $slide = $this->heroSlideService->findById($id);
        $translations = [];

        foreach ($slide->translations as $translation) {
            $translations[$translation->lang_code] = [
                'title' => $translation->title,
                'subtitle' => $translation->subtitle
            ];
        }

        return response()->json([
            'success' => true,
            'slide' => [
                'id' => $slide->id,
                'sort_order' => $slide->sort_order,
                'is_active' => $slide->is_active
            ],
            'translations' => $translations
        ]);
    }

    public function store(HeroSlideRequest $request): RedirectResponse
    {
        $this->heroSlideService->create($request->validated());
        return redirect()->route('hero-slides.index')->with('success', 'Слайд успешно создан');
    }

    public function update(HeroSlideRequest $request, int $id): RedirectResponse
    {
        $this->heroSlideService->update($id, $request->validated());
        return redirect()->route('hero-slides.index')->with('success', 'Слайд успешно обновлен');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->heroSlideService->delete($id);
        return redirect()->route('hero-slides.index')->with('success', 'Слайд успешно удален');
    }
}
