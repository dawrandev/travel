<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutBannerRequest;
use App\Http\Requests\AboutRequest;
use App\Models\Language;
use App\Services\AboutBannerService;
use App\Services\AboutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __construct(
        protected AboutService $aboutService,
        protected AboutBannerService $aboutBannerService
    ) {}

    public function index(): View
    {
        $about = $this->aboutService->getAll()->first();
        $banner = \App\Models\AboutBanner::first();
        $languages = Language::all();
        return view('pages.abouts.index', compact('about', 'banner', 'languages'));
    }

    public function filter(Request $request): JsonResponse
    {
        $langCode = $request->get('lang_code', 'en');
        $abouts = $this->aboutService->getAllByLanguage($langCode);

        $result = $abouts->map(function ($about) {
            $firstImage = $about->images()->orderBy('sort_order')->first();

            return [
                'id' => $about->id,
                'title' => $about->title,
                'description' => $about->description,
                'is_active' => $about->is_active,
                'first_image' => $firstImage ? $firstImage->image_path : null,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }
    public function getTranslations(int $id): JsonResponse
    {
        $about = $this->aboutService->findById($id);

        $translations = [];
        foreach ($about->translations as $translation) {
            $translations[$translation->lang_code] = [
                'title' => $translation->title,
                'description' => $translation->description
            ];
        }

        $images = $about->images->sortBy('sort_order')->map(function ($image) {
            return [
                'id' => $image->id,
                'image_path' => $image->image_path,
                'sort_order' => $image->sort_order,
            ];
        })->values()->toArray();

        return response()->json([
            'success' => true,
            'about' => [
                'id' => $about->id,
                'is_active' => $about->is_active
            ],
            'translations' => $translations,
            'images' => $images
        ]);
    }
    public function store(AboutRequest $request): RedirectResponse
    {
        $this->aboutService->create($request->validated());
        return redirect()->route('abouts.index')->with('success', 'О нас успешно создано');
    }

    public function update(AboutRequest $request, int $id): RedirectResponse
    {
        $this->aboutService->update($id, $request->validated());
        return redirect()->route('abouts.index')->with('success', 'О нас успешно обновлено');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->aboutService->delete($id);
        return redirect()->route('abouts.index')->with('success', 'О нас успешно удалено');
    }

    public function storeBanner(AboutBannerRequest $request): RedirectResponse
    {
        $this->aboutBannerService->create($request->validated());
        return redirect()->route('abouts.index')->with('success', 'Баннер успешно создан');
    }

    public function updateBanner(AboutBannerRequest $request, int $id): RedirectResponse
    {
        $this->aboutBannerService->update($id, $request->validated());
        return redirect()->route('abouts.index')->with('success', 'Баннер успешно обновлен');
    }

    public function getBannerTranslations(int $id): JsonResponse
    {
        $banner = $this->aboutBannerService->findById($id);

        $translations = [];
        foreach ($banner->translations as $translation) {
            $translations[$translation->lang_code] = [
                'title' => $translation->title,
            ];
        }

        $images = $banner->images->sortBy('sort_order')->map(function ($image) {
            return [
                'id' => $image->id,
                'image_path' => $image->image_path,
                'sort_order' => $image->sort_order,
            ];
        })->values()->toArray();

        return response()->json([
            'success' => true,
            'banner' => [
                'id' => $banner->id,
                'is_active' => $banner->is_active
            ],
            'translations' => $translations,
            'images' => $images
        ]);
    }
}
