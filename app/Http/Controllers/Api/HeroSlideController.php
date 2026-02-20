<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HeroSlideResource;
use App\Models\HeroSlide;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class HeroSlideController extends Controller
{
    #[OA\Get(
        path: "/hero-slides",
        tags: ["Hero Slides"],
        summary: "Bosh sahifa slaydlarini olish",
        parameters: [
            new OA\Parameter(
                name: "Accept-Language",
                in: "header",
                description: "Til kodi (kk, uz, ru, en)",
                required: false,
                schema: new OA\Schema(type: "string", default: "uz")
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
                                    // Rasm yo'li standart ko'rinishda namuna
                                    new OA\Property(property: "image_path", type: "string", nullable: false, example: "/storage/uploads/hero-banner-1.jpg"),
                                    new OA\Property(property: "sort_order", type: "integer", nullable: false, example: 1),
                                    new OA\Property(property: "title", type: "string", nullable: false, example: "Sayohatni biz bilan boshlang"),
                                    new OA\Property(property: "subtitle", type: "string", nullable: false, example: "Eng unutilmas lahzalar"),
                                    new OA\Property(property: "description", type: "string", nullable: true, example: "Ekspeditsiyalar haqida qisqacha ma'lumot")
                                ]
                            )
                        )
                    ]
                )
            )
        ]
    )]
    public function index(): JsonResponse
    {
        $slides = HeroSlide::with('translations')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => HeroSlideResource::collection($slides)
        ]);
    }
}
