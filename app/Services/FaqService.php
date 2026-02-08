<?php

namespace App\Services;

use App\Models\Language;
use App\Repositories\FaqRepository;

class FaqService
{
    public function __construct(
        protected FaqRepository $faqRepository
    ) {}

    public function getAll()
    {
        return $this->faqRepository->getAll();
    }

    public function getAllByLanguage(string $langCode, ?int $tourId = null)
    {
        $faqs = $this->faqRepository->getAll();

        // Filter by tour_id if provided
        if ($tourId !== null) {
            $faqs = $faqs->where('tour_id', $tourId);
        }

        return $faqs->map(function ($faq) use ($langCode) {
            $translation = $faq->translations->where('lang_code', $langCode)->first();

            $tourTitle = null;
            if ($faq->tour) {
                $tourTranslation = $faq->tour->translations->where('lang_code', $langCode)->first();
                $tourTitle = $tourTranslation->title ?? 'N/A';
            }

            $categoryName = null;
            if ($faq->category) {
                $categoryTranslation = $faq->category->translations->where('lang_code', $langCode)->first();
                $categoryName = $categoryTranslation->name ?? 'N/A';
            }

            return [
                'id' => $faq->id,
                'question' => $translation->question ?? 'N/A',
                'answer' => $translation->answer ?? 'N/A',
                'tour_title' => $tourTitle,
                'category_name' => $categoryName,
                'sort_order' => $faq->sort_order,
                'is_active' => $faq->is_active
            ];
        });
    }

    public function filter(string $langCode, ?int $tourId = null, ?int $categoryId = null, ?string $search = null)
    {
        $faqs = $this->faqRepository->getAll();

        // Filter by tour_id if provided
        if ($tourId !== null) {
            $faqs = $faqs->where('tour_id', $tourId);
        }

        // Filter by category_id if provided
        if ($categoryId !== null) {
            $faqs = $faqs->where('faq_category_id', $categoryId);
        }

        // Search filter
        if ($search !== null && $search !== '') {
            $faqs = $faqs->filter(function ($faq) use ($langCode, $search) {
                $translation = $faq->translations->where('lang_code', $langCode)->first();
                if (!$translation) {
                    return false;
                }

                $searchLower = mb_strtolower($search);
                $questionLower = mb_strtolower($translation->question ?? '');
                $answerLower = mb_strtolower($translation->answer ?? '');

                return str_contains($questionLower, $searchLower) ||
                       str_contains($answerLower, $searchLower);
            });
        }

        return $faqs->map(function ($faq) use ($langCode) {
            $translation = $faq->translations->where('lang_code', $langCode)->first();

            $tourTitle = null;
            if ($faq->tour) {
                $tourTranslation = $faq->tour->translations->where('lang_code', $langCode)->first();
                $tourTitle = $tourTranslation->title ?? 'N/A';
            }

            $categoryName = null;
            if ($faq->category) {
                $categoryTranslation = $faq->category->translations->where('lang_code', $langCode)->first();
                $categoryName = $categoryTranslation->name ?? 'N/A';
            }

            return [
                'id' => $faq->id,
                'question' => $translation->question ?? 'N/A',
                'answer' => $translation->answer ?? 'N/A',
                'tour_title' => $tourTitle,
                'category_name' => $categoryName,
                'sort_order' => $faq->sort_order,
                'is_active' => $faq->is_active
            ];
        })->values(); // Re-index array keys
    }

    public function findById(int $id)
    {
        return $this->faqRepository->findById($id);
    }

    public function create(array $data)
    {
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $faq = $this->faqRepository->create($data);

        // Create translations for all languages
        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->faqRepository->createTranslation($faq->id, [
                'question' => $data['question_' . $langCode] ?? '',
                'answer' => $data['answer_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $faq;
    }

    public function update(int $id, array $data)
    {
        $faq = $this->faqRepository->findById($id);

        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $this->faqRepository->update($faq, $data);

        // Delete old translations and create new ones
        $faq->translations()->delete();

        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->faqRepository->createTranslation($faq->id, [
                'question' => $data['question_' . $langCode] ?? '',
                'answer' => $data['answer_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $faq;
    }

    public function delete(int $id)
    {
        $faq = $this->faqRepository->findById($id);
        return $this->faqRepository->delete($faq);
    }
}
