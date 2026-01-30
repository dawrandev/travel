<?php

namespace App\Services;

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

    public function findById(int $id)
    {
        return $this->faqRepository->findById($id);
    }

    public function create(array $data)
    {
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $faq = $this->faqRepository->create($data);

        $this->faqRepository->createTranslation($faq->id, [
            'question' => $data['question'],
            'answer' => $data['answer'],
            'lang_code' => 'ru',
        ]);

        return $faq;
    }

    public function update(int $id, array $data)
    {
        $faq = $this->faqRepository->findById($id);

        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $this->faqRepository->update($faq, $data);

        $this->faqRepository->createTranslation($faq->id, [
            'question' => $data['question'],
            'answer' => $data['answer'],
            'lang_code' => 'ru',
        ]);

        return $faq;
    }

    public function delete(int $id)
    {
        $faq = $this->faqRepository->findById($id);
        return $this->faqRepository->delete($faq);
    }
}
