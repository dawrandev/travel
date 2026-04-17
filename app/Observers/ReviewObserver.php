<?php

namespace App\Observers;

use App\Models\Review;
use App\Models\Tour;

class ReviewObserver
{
    /**
     * Handle the Review "created" event.
     */
    public function created(Review $review): void
    {
        $this->updateTourRatingAndCount($review->tour_id);
    }

    /**
     * Handle the Review "updated" event.
     */
    public function updated(Review $review): void
    {
        $this->updateTourRatingAndCount($review->tour_id);
    }

    /**
     * Handle the Review "deleted" event.
     */
    public function deleted(Review $review): void
    {
        $this->updateTourRatingAndCount($review->tour_id);
    }

    /**
     * Update tour rating and reviews count based on active and checked reviews.
     */
    protected function updateTourRatingAndCount(int $tourId): void
    {
        $tour = Tour::find($tourId);

        if (!$tour) {
            return;
        }

        // Only count active and checked reviews
        $approvedReviews = Review::where('tour_id', $tourId)
            ->where('is_active', true)
            ->where('is_checked', true)
            ->get();

        $reviewsCount = $approvedReviews->count();
        $averageRating = $reviewsCount > 0
            ? round($approvedReviews->avg('rating'), 1)
            : 0;

        // Update tour without triggering events
        $tour->updateQuietly([
            'rating' => $averageRating,
            'reviews_count' => $reviewsCount,
        ]);
    }
}
