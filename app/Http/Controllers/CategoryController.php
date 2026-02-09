<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Language;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    public function index(): View
    {
        $categories = $this->categoryService->getAll();
        $languages = Language::all();
        return view('pages.categories.index', compact('categories', 'languages'));
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
}
