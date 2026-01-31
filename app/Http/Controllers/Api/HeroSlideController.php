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
                description: "Til kodi (languages jadvalidagi tillar)",
                required: false,
                schema: new OA\Schema(type: "string", default: "uz")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Muvaffaqiyatli javob")
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
