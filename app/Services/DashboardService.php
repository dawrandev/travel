<?php

namespace App\Services;

use App\Repositories\DashboardRepository;

class DashboardService
{
    protected DashboardRepository $repository;

    public function __construct(DashboardRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all dashboard statistics cards data
     */
    public function getCardsData(): array
    {
        return [
            'total_tours' => $this->repository->getTotalTours(),
            'total_reviews' => $this->repository->getTotalReviews(),
            'total_bookings' => $this->repository->getTotalBookings(),
            'total_questions' => $this->repository->getTotalQuestions(),
            'most_expensive_price' => $this->repository->getMostExpensiveTourPrice(),
            'highest_rated_tour' => $this->repository->getHighestRatedTour(),
            'total_categories' => $this->repository->getTotalCategories(),
            'total_features' => $this->repository->getTotalFeatures(),
        ];
    }

    /**
     * Get all charts data
     */
    public function getChartsData(): array
    {
        return [
            'tours_by_category' => $this->repository->getToursByCategory(),
            'bookings_by_month' => $this->repository->getBookingsByMonth(),
        ];
    }

    /**
     * Get all dashboard data
     */
    public function getDashboardData(): array
    {
        return [
            'cards' => $this->getCardsData(),
            'charts' => $this->getChartsData(),
        ];
    }
}
