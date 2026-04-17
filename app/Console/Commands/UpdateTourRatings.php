<?php

namespace App\Console\Commands;

use App\Models\Review;
use App\Models\Tour;
use Illuminate\Console\Command;

class UpdateTourRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tours:update-ratings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update rating and reviews_count for all tours based on approved reviews';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to update tour ratings and reviews count...');

        $tours = Tour::all();
        $progressBar = $this->output->createProgressBar($tours->count());
        $progressBar->start();

        foreach ($tours as $tour) {
            // Get all approved reviews for this tour
            $approvedReviews = Review::where('tour_id', $tour->id)
                ->where('is_active', true)
                ->where('is_checked', true)
                ->get();

            $reviewsCount = $approvedReviews->count();
            $averageRating = $reviewsCount > 0
                ? round($approvedReviews->avg('rating'), 1)
                : 0;

            // Update tour without triggering observers
            $tour->updateQuietly([
                'rating' => $averageRating,
                'reviews_count' => $reviewsCount,
            ]);

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();
        $this->info('Tour ratings and reviews count updated successfully!');
        $this->table(
            ['Total Tours', 'Updated'],
            [[$tours->count(), $tours->count()]]
        );

        return Command::SUCCESS;
    }
}
