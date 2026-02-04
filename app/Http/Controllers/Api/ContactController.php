<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactBannerResource;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\ContactBanner;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class ContactController extends Controller
{
    #[OA\Get(
        path: "/contact",
        tags: ["Contact"],
        summary: "Bog'lanish ma'lumotlarini olish",
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
        $contact = Contact::with('translations')->first();

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Ma\'lumot topilmadi'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new ContactResource($contact)
        ]);
    }

    #[OA\Get(
        path: "/contact/banner",
        tags: ["Contact"],
        summary: "Contact sahifasi bannerini olish",
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
                                new OA\Property(property: "title", type: "string", example: "Biz bilan bog'laning"),
                                new OA\Property(property: "image", type: "string", example: "/storage/uploads/contact-banner.jpg")
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
        $banner = ContactBanner::with('translations')
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
            'data' => new ContactBannerResource($banner)
        ]);
    }
}
