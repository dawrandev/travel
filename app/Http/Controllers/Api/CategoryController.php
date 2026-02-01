<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class CategoryController extends Controller
{
    #[OA\Get(
        path: "/categories",
        tags: ["Categories"],
        summary: "Barcha kategoriyalarni olish",
        description: "Aktiv kategoriyalarni ro'yxatini qaytaradi. Header orqali til kiritiladi va shu tildagi tarjima qaytariladi.",
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
                                    new OA\Property(property: "name", type: "string", example: "Tabiiy safari"),
                                    new OA\Property(property: "sort_order", type: "integer", example: 1),
                                    new OA\Property(property: "is_active", type: "boolean", example: true),
                                ]
                            )
                        ),
                    ]
                )
            )
        ]
    )]
    public function index(Request $request): JsonResponse
    {
        $categories = Category::with('translations')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => CategoryResource::collection($categories)
        ]);
    }
}

