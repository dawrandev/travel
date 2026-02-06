<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class QuestionController extends Controller
{
    #[OA\Post(
        path: "/questions",
        tags: ["Questions"],
        summary: "Yangi savol yuborish",
        description: "Foydalanuvchi tur haqida savol beradi. Barcha kerakli ma'lumotlarni to'ldirish shart.",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["tour_id", "full_name", "email", "phone", "comment"],
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
                        property: "email",
                        type: "string",
                        format: "email",
                        description: "Email manzil",
                        example: "alisher@example.com"
                    ),
                    new OA\Property(
                        property: "phone",
                        type: "string",
                        description: "Telefon raqam",
                        example: "+998901234567"
                    ),
                    new OA\Property(
                        property: "comment",
                        type: "string",
                        description: "Savol matni (maksimal 2000 belgi)",
                        example: "Bu tur qaysi oyda eng yaxshi vaqt? Va men bilan 5 yoshli bola boradi, bolalar uchun chegirma bormi?"
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Savol muvaffaqiyatli yuborildi",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Savolingiz muvaffaqiyatli yuborildi. Tez orada javob beramiz!"),
                        new OA\Property(
                            property: "data",
                            type: "object",
                            properties: [
                                new OA\Property(property: "id", type: "integer", example: 1),
                                new OA\Property(property: "tour_id", type: "integer", example: 1),
                                new OA\Property(property: "full_name", type: "string", example: "Alisher Navoiy"),
                                new OA\Property(property: "email", type: "string", example: "alisher@example.com"),
                                new OA\Property(property: "phone", type: "string", example: "+998901234567"),
                                new OA\Property(property: "comment", type: "string", example: "Bu tur qaysi oyda eng yaxshi vaqt?"),
                                new OA\Property(property: "status", type: "string", example: "pending", description: "pending yoki answered"),
                                new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2026-02-01T12:00:00.000000Z"),
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
                                    property: "email",
                                    type: "array",
                                    items: new OA\Items(type: "string", example: "Email majburiy")
                                ),
                                new OA\Property(
                                    property: "comment",
                                    type: "array",
                                    items: new OA\Items(type: "string", example: "Savol matni majburiy")
                                ),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Tur topilmadi",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: false),
                        new OA\Property(property: "message", type: "string", example: "Tanlangan tur topilmadi"),
                    ]
                )
            )
        ]
    )]
    public function store(QuestionRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Verify tour exists
        $tour = \App\Models\Tour::find($validated['tour_id']);
        if (!$tour) {
            return response()->json([
                'success' => false,
                'message' => 'Tanlangan tur topilmadi'
            ], 404);
        }

        // Status default 'pending' bo'ladi
        $validated['status'] = 'pending';

        $question = Question::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Savolingiz muvaffaqiyatli yuborildi. Tez orada javob beramiz!',
            'data' => [
                'id' => $question->id,
                'tour_id' => $question->tour_id,
                'full_name' => $question->full_name,
                'email' => $question->email,
                'phone' => $question->phone,
                'comment' => $question->comment,
                'status' => $question->status,
                'created_at' => $question->created_at,
            ]
        ], 201);
    }
}
