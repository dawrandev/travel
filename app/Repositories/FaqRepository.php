<?php

namespace App\Repositories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Collection;

class FaqRepository
{
    public function getAll(): Collection
    {
        return Faq::with(['translations', 'tour.translations'])
            ->orderBy('sort_order')
            ->get();
    }

    public function findById(int $id): ?Faq
    {
        return Faq::with('translations')->find($id);
    }

    public function create(array $data): Faq
    {
        return Faq::create($data);
    }

    public function update(Faq $faq, array $data): bool
    {
        return $faq->update($data);
    }

    public function delete(Faq $faq): bool
    {
        return $faq->delete();
    }

    public function createTranslation(int $faqId, array $data): void
    {
        Faq::find($faqId)->translations()->updateOrCreate(
            ['lang_code' => $data['lang_code']],
            $data
        );
    }

    public function getByTourId(int $tourId): Collection
    {
        return Faq::with('translations')
            ->where('tour_id', $tourId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
}
