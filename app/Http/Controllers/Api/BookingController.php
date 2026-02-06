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
                required: ["tour_id", "full_name", "max_people", "starting_date", "ending_date", "primary_phone", "email"],
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
                        property: "max_people",
                        type: "integer",
                        description: "Maksimal odamlar soni (narx avtomatik hisoblanadi)",
                        minimum: 1,
                        example: 2
                    ),
                    new OA\Property(
                        property: "starting_date",
                        type: "string",
                        format: "date",
                        description: "Boshlanish sanasi (YYYY-MM-DD)",
                        example: "2026-02-15"
                    ),
                    new OA\Property(
                        property: "ending_date",
                        type: "string",
                        format: "date",
                        description: "Tugash sanasi (YYYY-MM-DD)",
                        example: "2026-02-20"
                    ),
                    new OA\Property(
                        property: "primary_phone",
                        type: "string",
                        description: "Asosiy telefon raqam",
                        example: "+998901234567"
                    ),
                    new OA\Property(
                        property: "secondary_phone",
                        type: "string",
                        description: "Qo'shimcha telefon raqam (ixtiyoriy)",
                        example: "+998909876543"
                    ),
                    new OA\Property(
                        property: "email",
                        type: "string",
                        format: "email",
                        description: "Email manzil",
                        example: "alisher@example.com"
                    ),
                    new OA\Property(
                        property: "message",
                        type: "string",
                        description: "Xabar/izoh (ixtiyoriy)",
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
                                new OA\Property(property: "max_people", type: "integer", example: 2),
                                new OA\Property(property: "starting_date", type: "string", example: "2026-02-15"),
                                new OA\Property(property: "ending_date", type: "string", example: "2026-02-20"),
                                new OA\Property(property: "primary_phone", type: "string", example: "+998901234567"),
                                new OA\Property(property: "secondary_phone", type: "string", example: "+998909876543"),
                                new OA\Property(property: "email", type: "string", example: "alisher@example.com"),
                                new OA\Property(property: "message", type: "string", example: "Men vegetarian ovqat xohlayman"),
                                new OA\Property(property: "status", type: "string", example: "pending"),
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
                                    property: "primary_phone",
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

        // Verify tour exists
        \App\Models\Tour::findOrFail($validated['tour_id']);

        $booking = Booking::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully',
            'data' => [
                'id' => $booking->id,
                'tour_id' => $booking->tour_id,
                'full_name' => $booking->full_name,
                'max_people' => $booking->max_people,
                'starting_date' => $booking->starting_date->format('Y-m-d'),
                'ending_date' => $booking->ending_date->format('Y-m-d'),
                'primary_phone' => $booking->primary_phone,
                'secondary_phone' => $booking->secondary_phone,
                'email' => $booking->email,
                'message' => $booking->message,
                'status' => $booking->status,
            ]
        ], 201);
    }
}
