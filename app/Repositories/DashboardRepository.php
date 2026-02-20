<?php

namespace App\Repositories;

use App\Models\Tour;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Question;
use App\Models\Category;
use App\Models\Feature;
use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    /**
     * Get total tours count
     */
    public function getTotalTours(): int
    {
        return Tour::count();
    }

    /**
     * Get total reviews count
     */
    public function getTotalReviews(): int
    {
        return Review::count();
    }

    /**
     * Get total bookings count
     */
    public function getTotalBookings(): int
    {
        return Booking::count();
    }

    /**
     * Get total questions count
     */
    public function getTotalQuestions(): int
    {
        return Question::count();
    }

    /**
     * Get most expensive tour price
     */
    public function getMostExpensiveTourPrice(): float
    {
        return Tour::max('price') ?? 0;
    }

    /**
     * Get highest rated tour with details
     */
    public function getHighestRatedTour(): ?array
    {
        $tour = Tour::with('translations')
            ->orderBy('rating', 'desc')
            ->first();

        if (!$tour) {
            return null;
        }

        return [
            'name' => $tour->translations->first()?->name ?? 'N/A',
            'rating' => $tour->rating,
            'reviews_count' => $tour->reviews_count,
        ];
    }

    /**
     * Get total categories count
     */
    public function getTotalCategories(): int
    {
        return Category::count();
    }

    /**
     * Get total features count
     */
    public function getTotalFeatures(): int
    {
        return Feature::count();
    }

    /**
     * Get tours count by category for chart
     */
    public function getToursByCategory(): array
    {
        $data = Category::with('translations')
            ->withCount('tours')
            ->having('tours_count', '>', 0)
            ->get()
            ->map(function ($category) {
                $russianTranslation = $category->translations->firstWhere('lang_code', 'ru');
                $name = $russianTranslation?->name ?? 'N/A';
                return [
                    'name' => $name,
                    'count' => $category->tours_count,
                ];
            });

        return [
            'labels' => $data->pluck('name')->toArray(),
            'data' => $data->pluck('count')->toArray(),
        ];
    }

    /**
     * Get bookings count by month for the last 12 months
     */
    public function getBookingsByMonth(): array
    {
        $bookings = Booking::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Generate last 12 months
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('Y-m'));
        }

        // Merge with actual data
        $labels = [];
        $data = [];

        foreach ($months as $month) {
            $booking = $bookings->firstWhere('month', $month);
            $labels[] = date('M Y', strtotime($month . '-01'));
            $data[] = $booking ? $booking->count : 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
