<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('tour.translations');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('phone_primary', 'like', "%{$search}%")
                  ->orWhere('phone_secondary', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);

        // AJAX request
        if ($request->ajax()) {
            return view('pages.bookings.table', compact('bookings'))->render();
        }

        return view('pages.bookings.index', compact('bookings'));
    }

    public function show(int $id)
    {
        $booking = Booking::with('tour.translations')->findOrFail($id);
        return response()->json($booking);
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]);

        return redirect()->route('bookings.index')->with('success', 'Статус бронирования обновлен');
    }

    public function destroy(int $id): RedirectResponse
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Бронирование успешно удалено');
    }
}
