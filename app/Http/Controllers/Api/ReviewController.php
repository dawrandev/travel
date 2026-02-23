<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreClientReviewRequest;
use App\Http\Resources\ReviewBannerResource;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Models\ReviewBanner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ReviewController extends Controller
{
    #[OA\Get(
        path: "/reviews",
        tags: ["Reviews"],
        summary: "Barcha sharhlarni olish",
        description: "Admin tomonidan yaratilgan aktiv sharhlarni ro'yxatini qaytaradi. Tour bo'yicha filter qilish mumkin. (client_created = false)",
        parameters: [
            new OA\Parameter(
                name: "Accept-Language",
                in: "header",
                description: "Til kodi (uz, ru, kk, en)",
                required: false,
                schema: new OA\Schema(type: "string", default: "uz", enum: ["uz", "ru", "kk", "en"])
            ),
            new OA\Parameter(
                name: "tour_id",
                in: "query",
                description: "Tur ID (ixtiyoriy)",
                required: false,
                schema: new OA\Schema(type: "integer", example: 1)
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
                                    new OA\Property(property: "user_name", type: "string", example: "Alisher Navoiy"),
                                    new OA\Property(property: "city", type: "string", nullable: true, example: "Toshkent"),
                                    new OA\Property(property: "comment", type: "string", example: "Ajoyib tur edi! Juda yoqdi, hamma narsasi mukammal tashkil etilgan."),
                                    new OA\Property(property: "rating", type: "integer", example: 5),
                                    new OA\Property(property: "sort_order", type: "integer", nullable: false, example: 1),
                                    new OA\Property(property: "is_active", type: "boolean", nullable: false, example: true),
                                    new OA\Property(property: "video_url", type: "string", nullable: true, example: "https://youtube.com/watch?v=xxx"),
                                    new OA\Property(
                                        property: "tour",
                                        type: "object",
                                        properties: [
                                            new OA\Property(property: "id", type: "integer", example: 1),
                                            new OA\Property(property: "title", type: "string", example: "Orol dengizi safari"),
                                        ]
                                    ),
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
        $lang = $request->header('Accept-Language', 'uz');

        $query = Review::with(['translations', 'tour.translations'])
            ->where('is_active', true)
            ->where('is_checked', true)
            ->where('client_created', false);

        // Filter by tour if provided
        if ($request->has('tour_id')) {
            $query->where('tour_id', $request->tour_id);
        }

        $reviews = $query->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => ReviewResource::collection($reviews)
        ]);
    }

    #[OA\Post(
        path: "/reviews",
        tags: ["Reviews"],
        summary: "Yangi sharh qo'shish",
        description: "Foydalanuvchi tomonidan yangi sharh qo'shish",
        parameters: [
            new OA\Parameter(
                name: "Accept-Language",
                in: "header",
                description: "Til kodi (uz, ru, kk, en)",
                required: false,
                schema: new OA\Schema(type: "string", default: "uz", enum: ["uz", "ru", "kk", "en"])
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["tour_id", "name", "email", "rating", "comment"],
                properties: [
                    new OA\Property(property: "tour_id", type: "integer", example: 1, description: "Tur ID"),
                    new OA\Property(property: "name", type: "string", example: "Alisher Navoiy", description: "Foydalanuvchi ismi"),
                    new OA\Property(property: "email", type: "string", format: "email", example: "user@example.com", description: "Foydalanuvchi email"),
                    new OA\Property(property: "rating", type: "integer", example: 5, description: "Reyting (1-5)"),
                    new OA\Property(property: "comment", type: "string", example: "Ajoyib tur edi!", description: "Sharh mazmuni")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Sharh muvaffaqiyatli qo'shildi",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "success", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Your review has been submitted and is pending approval"),
                        new OA\Property(
                            property: "data",
                            type: "object",
                            properties: [
                                new OA\Property(property: "id", type: "integer", example: 1),
                                new OA\Property(property: "tour_id", type: "integer", example: 1),
                                new OA\Property(property: "name", type: "string", example: "Alisher Navoiy"),
                                new OA\Property(property: "rating", type: "integer", example: 5),
                                new OA\Property(property: "comment", type: "string", example: "Ajoyib tur edi!"),
                                new OA\Property(property: "is_checked", type: "boolean", example: false),
                                new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2025-02-20T10:30:00Z")
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(response: 422, description: "Validatsiya xatosi")
        ]
    )]
    public function store(StoreClientReviewRequest $request): JsonResponse
    {
        $review = Review::create([
            'tour_id' => $request->tour_id,
            'user_name' => $request->name,
            'email' => $request->email,
            'rating' => $request->rating,
            'is_active' => true,
            'is_checked' => false,
            'client_created' => true,
            'sort_order' => 0,
        ]);

        $lang = $request->header('Accept-Language', 'uz');
        $review->translations()->create([
            'lang_code' => $lang,
            'city' => null,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your review has been submitted and is pending approval',
            'data' => [
                'id' => $review->id,
                'tour_id' => $review->tour_id,
                'name' => $review->user_name,
                'rating' => $review->rating,
                'comment' => $request->comment,
                'is_checked' => false,
                'created_at' => $review->created_at,
            ]
        ], 201);
    }

    #[OA\Get(
        path: "/reviews/{id}",
        tags: ["Reviews"],
        summary: "Bitta sharhni olish",
        description: "ID bo'yicha sharhni qaytaradi",
        parameters: [
            new OA\Parameter(
                name: "Accept-Language",
                in: "header",
                description: "Til kodi (uz, ru, kk, en)",
                required: false,
                schema: new OA\Schema(type: "string", default: "uz", enum: ["uz", "ru", "kk", "en"])
            ),
            new OA\Parameter(
                name: "id",
                in: "path",
                description: "Sharh ID",
                required: true,
                schema: new OA\Schema(type: "integer", example: 1)
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
                                new OA\Property(property: "user_name", type: "string", example: "Alisher Navoiy"),
                                new OA\Property(property: "city", type: "string", nullable: true, example: "Toshkent"),
                                new OA\Property(property: "comment", type: "string", example: "Ajoyib tur edi! Juda yoqdi, hamma narsasi mukammal tashkil etilgan."),
                                new OA\Property(property: "rating", type: "integer", example: 5),
                                new OA\Property(property: "sort_order", type: "integer", nullable: false, example: 1),
                                new OA\Property(property: "is_active", type: "boolean", nullable: false, example: true),
                                new OA\Property(property: "video_url", type: "string", nullable: true, example: "https://youtube.com/watch?v=xxx"),
                                new OA\Property(
                                    property: "tour",
                                    type: "object",
                                    properties: [
                                        new OA\Property(property: "id", type: "integer", example: 1),
                                        new OA\Property(property: "title", type: "string", example: "Orol dengizi safari"),
                                    ]
                                ),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(response: 404, description: "Sharh topilmadi")
        ]
    )]
    public function show(Request $request, int $id): JsonResponse
    {
        $review = Review::with(['translations', 'tour.translations'])
            ->where('is_active', true)
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => new ReviewResource($review)
        ]);
    }

    #[OA\Get(
        path: "/reviews/banner",
        tags: ["Reviews"],
        summary: "Reviews sahifasi bannerini olish",
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
                                new OA\Property(property: "title", type: "string", example: "Mijozlar sharhlari"),
                                new OA\Property(property: "is_active", type: "boolean", nullable: false, example: true),
                                new OA\Property(
                                    property: "images",
                                    type: "array",
                                    description: "Banner rasmlari massivi (tartiblangan)",
                                    items: new OA\Items(type: "string", example: "/storage/uploads/banners/review-banner-1.jpg")
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
        $banner = ReviewBanner::with(['translations', 'images' => function ($q) {
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
            'data' => new ReviewBannerResource($banner)
        ]);
    }
}
