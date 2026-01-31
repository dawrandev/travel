<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;
use App\Models\About;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AboutController extends Controller
{
    #[OA\Get(
        path: "/about",
        tags: ["About"],
        summary: "Biz haqimizda ma'lumotini olish",
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
            new OA\Response(response: 200, description: "Muvaffaqiyatli javob"),
            new OA\Response(response: 404, description: "Ma'lumot topilmadi")
        ]
    )]
    public function index(): JsonResponse
    {
        $about = About::with(['translations', 'images' => function ($q) {
            $q->orderBy('sort_order');
        }])->where('is_active', true)->first();

        if (!$about) {
            return response()->json([
                'success' => false,
                'message' => 'Ma\'lumot topilmadi'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new AboutResource($about)
        ]);
    }
}
