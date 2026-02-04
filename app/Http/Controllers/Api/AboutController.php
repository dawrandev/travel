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
                            type: "object",
                            properties: [
                                new OA\Property(property: "id", type: "integer", example: 1),
                                new OA\Property(property: "title", type: "string", example: "Sarguzashtlar olami"),
                                new OA\Property(property: "description", type: "string", example: "Biz haqimizda batafsil..."),
                                new OA\Property(
                                    property: "images",
                                    type: "array",
                                    description: "Rasmlar ro'yxati (tartiblangan)",
                                    items: new OA\Items(
                                        properties: [
                                            new OA\Property(property: "id", type: "integer", example: 1),
                                            new OA\Property(property: "image_path", type: "string", example: "/storage/uploads/gallery-1.jpg")
                                        ],
                                        type: "object"
                                    )
                                )
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Ma'lumot topilmadi",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: false),
                        new OA\Property(property: "message", type: "string", example: "Ma'lumot topilmadi")
                    ]
                )
            )
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
