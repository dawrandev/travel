<?php

namespace App\Repositories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;

class ReviewRepository
{
    public function getAll(): Collection
    {
        return Review::with(['translations', 'tour'])->orderBy('sort_order')->get();
    }

    public function findById(int $id): ?Review
    {
        return Review::with(['translations', 'tour'])->find($id);
    }

    public function create(array $data): Review
    {
        return Review::create($data);
    }

    public function update(Review $review, array $data): bool
    {
        return $review->update($data);
    }

    public function delete(Review $review): bool
    {
        return $review->delete();
    }

    public function createTranslation(int $reviewId, array $data): void
    {
        Review::find($reviewId)->translations()->updateOrCreate(
            ['lang_code' => $data['lang_code']],
            $data
        );
    }
}
