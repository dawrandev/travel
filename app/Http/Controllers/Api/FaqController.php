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
        summary: "Ko'p beriladigan savollar ro'yxatini olish",
        parameters: [
            new OA\Parameter(
                name: "Accept-Language",
                in: "header",
                description: "Til kodi (languages jadvalidagi tillar)",
                required: false,
                schema: new OA\Schema(type: "string", default: "uz")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Muvaffaqiyatli javob"
            )
        ]
    )]
    public function index(): JsonResponse
    {
        $faqs = Faq::with('translations')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => FaqResource::collection($faqs)
        ]);
    }
}
