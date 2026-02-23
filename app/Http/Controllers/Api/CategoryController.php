<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryBannerResource;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\CategoryBanner;
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
                                    new OA\Property(property: "name", type: "string", nullable: false, example: "Tabiiy safari"),
                                    new OA\Property(property: "sort_order", type: "integer", nullable: false, example: 1),
                                    new OA\Property(property: "is_active", type: "boolean", nullable: false, example: true),
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

    #[OA\Get(
        path: "/categories/banner",
        tags: ["Categories"],
        summary: "Kategoriyalar sahifasi bannerini olish",
        parameters: [
            new OA\Parameter(
                name: "Accept-Language",
                in: "header",
                description: "Til kodi (uz, ru, kk, en)",
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
                                new OA\Property(property: "title", type: "string", example: "Kategoriyalar"),
                                new OA\Property(property: "is_active", type: "boolean", nullable: false, example: true),
                                new OA\Property(
                                    property: "images",
                                    type: "array",
                                    description: "Banner rasmlari massivi (tartiblangan)",
                                    items: new OA\Items(type: "string", example: "/storage/uploads/banners/category-banner-1.jpg")
                                )
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(response: 404, description: "Banner topilmadi")
        ]
    )]
    public function banner(): JsonResponse
    {
        $banner = CategoryBanner::with(['translations', 'images' => function ($q) {
            $q->orderBy('sort_order');
        }])
            ->where('is_active', true)
            ->first();

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Banner topilmadi'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new CategoryBannerResource($banner)
        ]);
    }
}

