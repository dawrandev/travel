<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class FaqController extends Controller
{
    #[OA\Get(
        path: "/faq",
        tags: ["FAQ"],
        summary: "Umumiy FAQ lar ro'yxatini olish",
        description: "Faqat umumiy (tourga tegishli bo'lmagan) FAQ larni qaytaradi",
        parameters: [
            new OA\Parameter(
                name: "Accept-Language",
                in: "header",
                description: "Til kodi (uz, ru, kk, en)",
                required: false,
                schema: new OA\Schema(type: "string", default: "uz", enum: ["uz", "ru", "kk", "en"])
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Muvaffaqiyatli javob",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: "id", type: "integer", example: 1),
                                    new OA\Property(property: "sort_order", type: "integer", example: 1),
                                    new OA\Property(property: "question", type: "string", example: "Orolga borish uchun eng maqbul vaqt qachon?"),
                                    new OA\Property(property: "answer", type: "string", example: "Bizda iqlim keskin kontinental. Sayohat uchun eng ideal vaqt — bahor (aprel-may) va kuz (sentyabr-oktyabr) oylaridir."),
                                ]
                            )
                        ),
                    ]
                )
            )
        ]
    )]
    public function index(): JsonResponse
    {
        $faqs = Faq::with('translations')
            ->whereNull('tour_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => FaqResource::collection($faqs)
        ]);
    }
}
