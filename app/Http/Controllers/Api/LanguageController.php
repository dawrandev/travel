<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class LanguageController extends Controller
{
    #[OA\Get(
        path: "/languages",
        tags: ["Languages"],
        summary: "Mavjud tillar ro'yxatini olish",
        responses: [
            new OA\Response(response: 200, description: "Muvaffaqiyatli javob")
        ]
    )]
    public function index(): JsonResponse
    {
        $languages = Language::where('is_active', true)
            ->select('id', 'name', 'code')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $languages
        ]);
    }
}
