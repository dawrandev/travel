<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaqCategoryRequest;
use App\Models\Language;
use App\Services\FaqCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqCategoryController extends Controller
{
    public function __construct(
        protected FaqCategoryService $faqCategoryService
    ) {}

    public function index(): View
    {
        $faqCategories = $this->faqCategoryService->getAll();
        $languages = Language::where('is_active', true)->get();
        return view('pages.faq-categories.index', compact('faqCategories', 'languages'));
    }

    public function filter(Request $request): JsonResponse
    {
        $langCode = $request->get('lang_code', 'ru');

        $faqCategories = $this->faqCategoryService->getAllByLanguage($langCode);

        return response()->json([
            'success' => true,
            'data' => $faqCategories
        ]);
    }

    public function getTranslations(int $id): JsonResponse
    {
        $faqCategory = $this->faqCategoryService->findById($id);
        $translations = [];

        foreach ($faqCategory->translations as $translation) {
            $translations[$translation->lang_code] = [
                'name' => $translation->name
            ];
        }

        return response()->json([
            'success' => true,
            'faqCategory' => [
                'id' => $faqCategory->id,
                'sort_order' => $faqCategory->sort_order,
                'is_active' => $faqCategory->is_active
            ],
            'translations' => $translations
        ]);
    }

    public function store(FaqCategoryRequest $request): RedirectResponse
    {
        $this->faqCategoryService->create($request->validated());
        return redirect()->route('faq-categories.index')->with('success', 'Категория FAQ успешно создана');
    }

    public function update(FaqCategoryRequest $request, int $id): RedirectResponse
    {
        $this->faqCategoryService->update($id, $request->validated());
        return redirect()->route('faq-categories.index')->with('success', 'Категория FAQ успешно обновлена');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->faqCategoryService->delete($id);
        return redirect()->route('faq-categories.index')->with('success', 'Категория FAQ успешно удалена');
    }
}
