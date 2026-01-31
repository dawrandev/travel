<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
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
}
