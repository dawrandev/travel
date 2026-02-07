<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaqRequest;
use App\Models\FaqCategory;
use App\Models\Language;
use App\Models\Tour;
use App\Services\FaqService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function __construct(
        protected FaqService $faqService
    ) {}

    public function index(): View
    {
        $faqs = $this->faqService->getAll();
        $languages = Language::all();
        $tours = Tour::with('translations')->get();
        $faqCategories = FaqCategory::with('translations')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        return view('pages.faqs.index', compact('faqs', 'languages', 'tours', 'faqCategories'));
    }

    public function filter(Request $request): JsonResponse
    {
        $langCode = $request->get('lang_code', 'en');
        $tourId = $request->get('tour_id');

        // Convert empty string to null
        $tourId = $tourId === '' || $tourId === null ? null : (int) $tourId;

        $faqs = $this->faqService->getAllByLanguage($langCode, $tourId);

        return response()->json([
            'success' => true,
            'data' => $faqs
        ]);
    }

    public function getTranslations(int $id): JsonResponse
    {
        $faq = $this->faqService->findById($id);
        $translations = [];

        foreach ($faq->translations as $translation) {
            $translations[$translation->lang_code] = [
                'question' => $translation->question,
                'answer' => $translation->answer
            ];
        }

        return response()->json([
            'success' => true,
            'faq' => [
                'id' => $faq->id,
                'tour_id' => $faq->tour_id,
                'faq_category_id' => $faq->faq_category_id,
                'sort_order' => $faq->sort_order,
                'is_active' => $faq->is_active
            ],
            'translations' => $translations
        ]);
    }

    public function store(FaqRequest $request): RedirectResponse
    {
        $this->faqService->create($request->validated());
        return redirect()->route('faqs.index')->with('success', 'Вопрос успешно создан');
    }

    public function update(FaqRequest $request, int $id): RedirectResponse
    {
        $this->faqService->update($id, $request->validated());
        return redirect()->route('faqs.index')->with('success', 'Вопрос успешно обновлен');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->faqService->delete($id);
        return redirect()->route('faqs.index')->with('success', 'Вопрос успешно удален');
    }
}
