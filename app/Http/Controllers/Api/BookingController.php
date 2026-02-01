<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class BookingController extends Controller
{
    #[OA\Post(
        path: "/bookings",
        tags: ["Bookings"],
        summary: "Yangi bron yaratish",
        description: "Foydalanuvchi tur uchun bron qiladi. Barcha kerakli ma'lumotlarni to'ldirish shart.",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["tour_id", "full_name", "phone_primary", "booking_date", "people_count"],
                properties: [
                    new OA\Property(
                        property: "tour_id",
                        type: "integer",
                        description: "Tur ID",
                        example: 1
                    ),
                    new OA\Property(
                        property: "full_name",
                        type: "string",
                        description: "To'liq ism",
                        example: "Alisher Navoiy"
                    ),
                    new OA\Property(
                        property: "phone_primary",
                        type: "string",
                        description: "Asosiy telefon raqam",
                        example: "+998901234567"
                    ),
                    new OA\Property(
                        property: "phone_secondary",
                        type: "string",
                        description: "Qo'shimcha telefon raqam (ixtiyoriy)",
                        example: "+998909876543"
                    ),
                    new OA\Property(
                        property: "booking_date",
                        type: "string",
                        format: "date",
                        description: "Bron qilish sanasi (YYYY-MM-DD)",
                        example: "2026-02-15"
                    ),
                    new OA\Property(
                        property: "people_count",
                        type: "integer",
                        description: "Odamlar soni (narx avtomatik hisoblanadi)",
                        minimum: 1,
                        example: 2
                    ),
                    new OA\Property(
                        property: "comment",
                        type: "string",
                        description: "Izoh (ixtiyoriy)",
                        example: "Men vegetarian ovqat xohlayman"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Bron muvaffaqiyatli yaratildi",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Booking created successfully"),
                        new OA\Property(
                            property: "data",
                            type: "object",
                            properties: [
                                new OA\Property(property: "id", type: "integer", example: 1),
                                new OA\Property(property: "tour_id", type: "integer", example: 1),
                                new OA\Property(property: "full_name", type: "string", example: "Alisher Navoiy"),
                                new OA\Property(property: "phone_primary", type: "string", example: "+998901234567"),
                                new OA\Property(property: "phone_secondary", type: "string", example: "+998909876543"),
                                new OA\Property(property: "booking_date", type: "string", example: "2026-02-15"),
                                new OA\Property(property: "people_count", type: "integer", example: 2),
                                new OA\Property(property: "total_price", type: "number", example: 1500000.00, description: "Avtomatik hisoblangan umumiy narx"),
                                new OA\Property(property: "price_per_person", type: "number", example: 750000.00, description: "Har bir kishi uchun narx"),
                                new OA\Property(property: "status", type: "string", example: "pending"),
                                new OA\Property(property: "comment", type: "string", example: "Men vegetarian ovqat xohlayman"),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: "Validatsiya xatosi",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "message", type: "string", example: "The given data was invalid."),
                        new OA\Property(
                            property: "errors",
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "phone_primary",
                                    type: "array",
                                    items: new OA\Items(type: "string", example: "Primary phone number is required.")
                                ),
                            ]
                        ),
                    ]
                )
            )
        ]
    )]
    public function store(BookingRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Get tour price
        $tour = \App\Models\Tour::findOrFail($validated['tour_id']);
        $basePrice = $tour->price;
        $peopleCount = $validated['people_count'];

        // Calculate total price based on people count
        $priceCoefficients = [
            1 => 1.0,   // 100%
            2 => 0.8,   // 80%
            3 => 0.6,   // 60%
            4 => 0.56,  // 56%
            5 => 0.52,  // 52%
            6 => 0.52,  // 52%
        ];

        // For 7+ people use 0.48 (48%)
        $coefficient = $priceCoefficients[$peopleCount] ?? 0.48;
        $totalPrice = $basePrice * $coefficient * $peopleCount;

        // Add total_price to validated data
        $validated['total_price'] = $totalPrice;

        $booking = Booking::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully',
            'data' => [
                'id' => $booking->id,
                'tour_id' => $booking->tour_id,
                'full_name' => $booking->full_name,
                'phone_primary' => $booking->phone_primary,
                'phone_secondary' => $booking->phone_secondary,
                'booking_date' => $booking->booking_date->format('Y-m-d'),
                'people_count' => $booking->people_count,
                'total_price' => (float) $booking->total_price,
                'price_per_person' => (float) ($booking->total_price / $booking->people_count),
                'status' => $booking->status,
                'comment' => $booking->comment,
            ]
        ], 201);
    }
}
