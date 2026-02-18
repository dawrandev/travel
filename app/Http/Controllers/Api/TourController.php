<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Http\Resources\TourDetailResource;
use App\Models\Tour;
use App\Repositories\TourRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class TourController extends Controller
{
    public function __construct(
        protected TourRepository $tourRepository
    ) {}

    #[OA\Get(
        path: "/tours",
        tags: ["Tours"],
        summary: "Barcha turlarni olish",
        description: "Aktiv turlarni ro'yxatini qaytaradi. Category bo'yicha filter qilish mumkin.",
        parameters: [
            new OA\Parameter(
                name: "Accept-Language",
                in: "header",
                description: "Til kodi (uz, ru, kk, en)",
                required: false,
                schema: new OA\Schema(type: "string", default: "uz", enum: ["uz", "ru", "kk", "en"])
            ),
            new OA\Parameter(
                name: "category_id",
                in: "query",
                description: "Kategoriya ID (ixtiyoriy)",
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
                                    new OA\Property(property: "title", type: "string", example: "Orol dengizi safari"),
                                    new OA\Property(property: "phone", type: "string", example: "+998901234567"), // Qo'shildi
                                    new OA\Property(property: "description", type: "string", example: "Ajoyib sayohat..."),
                                    new OA\Property(property: "routes", type: "string", example: "Toshkent - Nukus - Moynaq"),
                                    new OA\Property(property: "important_info", type: "string", example: "Pasport talab qilinadi"),
                                    new OA\Property(property: "price", type: "number", example: 1500000),
                                    new OA\Property(property: "duration_days", type: "integer", example: 3),
                                    new OA\Property(property: "duration_nights", type: "integer", example: 2),
                                    new OA\Property(property: "min_age", type: "integer", example: 18),
                                    new OA\Property(property: "max_people", type: "integer", example: 15),
                                    new OA\Property(property: "rating", type: "number", example: 4.5),
                                    new OA\Property(property: "reviews_count", type: "integer", example: 10),
                                    new OA\Property(
                                        property: "category",
                                        type: "object",
                                        properties: [
                                            new OA\Property(property: "id", type: "integer", example: 1),
                                            new OA\Property(property: "name", type: "string", example: "Tabiiy safari"),
                                        ]
                                    ),
                                    new OA\Property(property: "main_image", type: "string", example: "/storage/uploads/image.jpg"),
                                    new OA\Property(
                                        property: "images",
                                        type: "array",
                                        items: new OA\Items(
                                            properties: [
                                                new OA\Property(property: "id", type: "integer", example: 1),
                                                new OA\Property(property: "url", type: "string", example: "/storage/uploads/image.jpg"),
                                                new OA\Property(property: "is_main", type: "boolean", example: true),
                                            ]
                                        )
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
        $query = Tour::with(['translations', 'category.translations', 'images'])
            ->where('is_active', true);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $tours = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => TourResource::collection($tours)
        ]);
    }

    #[OA\Get(
        path: "/tours/{slug}",
        tags: ["Tours"],
        summary: "Bitta turni olish",
        description: "Slug bo'yicha turni batafsil ma'lumotlari bilan qaytaradi",
        parameters: [
            new OA\Parameter(
                name: "Accept-Language",
                in: "header",
                description: "Til kodi (uz, ru, kk, en)",
                required: false,
                schema: new OA\Schema(type: "string", default: "uz", enum: ["uz", "ru", "kk", "en"])
            ),
            new OA\Parameter(
                name: "slug",
                in: "path",
                description: "Tur slug (masalan: nukus-cultural-one-day-tour)",
                required: true,
                schema: new OA\Schema(type: "string", example: "nukus-cultural-one-day-tour")
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
                                new OA\Property(property: "title", type: "string", example: "Nukus madaniy turi"),
                                new OA\Property(property: "phone", type: "string", example: "+998901234567"), // Qo'shildi
                                new OA\Property(property: "slogan", type: "string", example: "O'zbekistonning madaniy poytaxti"),
                                new OA\Property(property: "description", type: "string", example: "Nukus shahrini va uning tarixiy joylarini kashf eting"),
                                new OA\Property(property: "routes", type: "string", example: "Toshkent - Nukus"),
                                new OA\Property(property: "important_info", type: "string", example: "Pasport talab qilinadi"),
                                new OA\Property(property: "price", type: "number", example: 500000),
                                new OA\Property(property: "duration_days", type: "integer", example: 1),
                                new OA\Property(property: "duration_nights", type: "integer", example: 0),
                                new OA\Property(property: "min_age", type: "integer", example: 0),
                                new OA\Property(property: "max_people", type: "integer", example: 15),
                                new OA\Property(property: "rating", type: "number", example: 4.5),
                                new OA\Property(property: "reviews_count", type: "integer", example: 10),
                                new OA\Property(
                                    property: "category",
                                    type: "object",
                                    properties: [
                                        new OA\Property(property: "id", type: "integer", example: 1),
                                        new OA\Property(property: "name", type: "string", example: "Madaniy turlar"),
                                    ]
                                ),
                                new OA\Property(property: "main_image", type: "string", example: "/storage/uploads/image.jpg"),
                                new OA\Property(
                                    property: "images",
                                    type: "array",
                                    items: new OA\Items(
                                        properties: [
                                            new OA\Property(property: "id", type: "integer", example: 1),
                                            new OA\Property(property: "url", type: "string", example: "/storage/uploads/image.jpg"),
                                            new OA\Property(property: "is_main", type: "boolean", example: true),
                                        ]
                                    )
                                ),
                                new OA\Property(
                                    property: "itineraries",
                                    type: "array",
                                    items: new OA\Items(
                                        properties: [
                                            new OA\Property(property: "day_number", type: "integer", example: 1),
                                            new OA\Property(property: "event_time", type: "string", example: "09:00"),
                                            new OA\Property(property: "activity_title", type: "string", example: "Shahar sayohati"),
                                            new OA\Property(property: "activity_description", type: "string", example: "Shahar markazini ko'rib chiqish"),
                                        ]
                                    )
                                ),
                                new OA\Property(
                                    property: "features",
                                    type: "array",
                                    items: new OA\Items(
                                        properties: [
                                            new OA\Property(property: "id", type: "integer", example: 1),
                                            new OA\Property(property: "name", type: "string", example: "Transfer"),
                                            new OA\Property(property: "description", type: "string", example: "Aeroportdan olib kelish"),
                                            new OA\Property(property: "icon", type: "string", example: "fas fa-bus"),
                                            new OA\Property(property: "is_included", type: "boolean", example: true),
                                        ]
                                    )
                                ),
                                new OA\Property(property: "gif_map", type: "string", nullable: true, example: "/storage/uploads/route.gif"),
                                new OA\Property(
                                    property: "accommodations",
                                    type: "array",
                                    description: "Har bir kun uchun turar joy yoki tavsiya",
                                    items: new OA\Items(
                                        properties: [
                                            new OA\Property(property: "day_number", type: "integer", example: 1, description: "Qaysi kun"),
                                            new OA\Property(
                                                property: "type",
                                                type: "string",
                                                enum: ["accommodation", "recommendation"],
                                                example: "accommodation",
                                                description: "accommodation — turar joy bor; recommendation — tavsiya"
                                            ),
                                            new OA\Property(property: "name", type: "string", example: "Hotel Jipek Joli"),
                                            new OA\Property(property: "description", type: "string", example: "Qulay mehmonxona, barcha qulayliklar bilan"),
                                            new OA\Property(property: "price", type: "number", nullable: true, example: 50.00),
                                            new OA\Property(property: "image", type: "string", nullable: true, example: "/storage/uploads/hotel.jpg"),
                                        ]
                                    )
                                ),
                                new OA\Property(
                                    property: "faq",
                                    type: "array",
                                    description: "Tourga tegishli FAQ lar, kategoriya bo'yicha guruhlanган",
                                    items: new OA\Items(
                                        properties: [
                                            new OA\Property(property: "title", type: "string", example: "Umumiy savollar"),
                                            new OA\Property(
                                                property: "questions",
                                                type: "array",
                                                items: new OA\Items(
                                                    properties: [
                                                        new OA\Property(property: "question", type: "string", example: "Nukus madaniy turi qancha vaqt davom etadi?"),
                                                        new OA\Property(property: "answer", type: "string", example: "Tur 1 kun davom etadi va soat 09:00 dan 18:00 gacha boradi."),
                                                    ]
                                                )
                                            ),
                                        ]
                                    )
                                ),
                            ]
                        ),
                    ]
                )
            ),
            new OA\Response(response: 404, description: "Tur topilmadi")
        ]
    )]
    public function show(string $slug): JsonResponse
    {
        $tour = $this->tourRepository->findBySlug($slug);

        if (!$tour) {
            return response()->json(['success' => false, 'message' => 'Tour not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new TourDetailResource($tour)
        ]);
    }

    #[OA\Get(
        path: "/tours/top-rated",
        tags: ["Tours"],
        summary: "Eng yuqori ratingli turlar",
        description: "Rating bo'yicha eng yuqori 6 ta aktiv turni qaytaradi",
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
                                    new OA\Property(property: "title", type: "string", example: "Orol dengizi safari"),
                                    new OA\Property(property: "phone", type: "string", example: "+998901234567"), // Qo'shildi
                                    new OA\Property(property: "description", type: "string", example: "Ajoyib sayohat..."),
                                    new OA\Property(property: "routes", type: "string", example: "Toshkent - Nukus - Moynaq"),
                                    new OA\Property(property: "important_info", type: "string", example: "Pasport talab qilinadi"),
                                    new OA\Property(property: "price", type: "number", example: 1500000),
                                    new OA\Property(property: "duration_days", type: "integer", example: 3),
                                    new OA\Property(property: "duration_nights", type: "integer", example: 2),
                                    new OA\Property(property: "min_age", type: "integer", example: 18),
                                    new OA\Property(property: "max_people", type: "integer", example: 15),
                                    new OA\Property(property: "rating", type: "number", example: 4.8, description: "Eng yuqori rating"),
                                    new OA\Property(property: "reviews_count", type: "integer", example: 25),
                                    new OA\Property(
                                        property: "category",
                                        type: "object",
                                        properties: [
                                            new OA\Property(property: "id", type: "integer", example: 1),
                                            new OA\Property(property: "name", type: "string", example: "Tabiiy safari"),
                                        ]
                                    ),
                                    new OA\Property(property: "main_image", type: "string", example: "/storage/image.jpg"),
                                    new OA\Property(
                                        property: "images",
                                        type: "array",
                                        items: new OA\Items(
                                            properties: [
                                                new OA\Property(property: "id", type: "integer", example: 1),
                                                new OA\Property(property: "url", type: "string", example: "/storage/uploads/image.jpg"),
                                                new OA\Property(property: "is_main", type: "boolean", example: true),
                                            ]
                                        )
                                    ),
                                ]
                            )
                        ),
                    ]
                )
            )
        ]
    )]
    public function topRated(Request $request): JsonResponse
    {
        $tours = Tour::with(['translations', 'category.translations', 'images'])
            ->where('is_active', true)
            ->whereNotNull('rating')
            ->orderBy('rating', 'desc')
            ->orderBy('reviews_count', 'desc')
            ->limit(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => TourResource::collection($tours)
        ]);
    }
}
