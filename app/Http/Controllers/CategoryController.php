<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryBannerRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\CategoryBanner;
use App\Models\Language;
use App\Services\CategoryBannerService;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService,
        protected CategoryBannerService $categoryBannerService
    ) {}

    public function index(): View
    {
        $categories = $this->categoryService->getAll();
        $banner = CategoryBanner::first();
        $languages = Language::all();
        return view('pages.categories.index', compact('categories', 'banner', 'languages'));
    }

    public function filter(Request $request): JsonResponse
    {
        $langCode = $request->get('lang_code', 'ru');
        $categories = $this->categoryService->getAllByLanguage($langCode);

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function getTranslations(int $id): JsonResponse
    {
        $category = $this->categoryService->findById($id);
        $translations = [];

        foreach ($category->translations as $translation) {
            $translations[$translation->lang_code] = [
                'name' => $translation->name
            ];
        }

        return response()->json([
            'success' => true,
            'category' => [
                'id' => $category->id,
                'sort_order' => $category->sort_order,
                'is_active' => $category->is_active
            ],
            'translations' => $translations
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->categoryService->create($request->validated());
        return redirect()->route('categories.index')->with('success', 'Категория успешно создана');
    }

    public function update(StoreCategoryRequest $request, int $id): RedirectResponse
    {
        $this->categoryService->update($id, $request->validated());
        return redirect()->route('categories.index')->with('success', 'Категория успешно обновлена');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->categoryService->delete($id);
        return redirect()->route('categories.index')->with('success', 'Категория успешно удалена');
    }

    public function storeBanner(CategoryBannerRequest $request): RedirectResponse
    {
        $this->categoryBannerService->create($request->validated());
        return redirect()->route('categories.index')->with('success', 'Баннер успешно создан');
    }

    public function updateBanner(CategoryBannerRequest $request, int $id): RedirectResponse
    {
        $this->categoryBannerService->update($id, $request->validated());
        return redirect()->route('categories.index')->with('success', 'Баннер успешно обновлен');
    }

    public function getBannerTranslations(int $id): JsonResponse
    {
        $banner = $this->categoryBannerService->findById($id);

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
