<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutRequest;
use App\Models\Language;
use App\Services\AboutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __construct(
        protected AboutService $aboutService
    ) {}

    public function index(): View
    {
        $abouts = $this->aboutService->getAll();
        $languages = Language::all();
        return view('pages.abouts.index', compact('abouts', 'languages'));
    }

    public function filter(Request $request): JsonResponse
    {
        $langCode = $request->get('lang_code', 'en');
        $abouts = $this->aboutService->getAllByLanguage($langCode);

        return response()->json([
            'success' => true,
            'data' => $abouts
        ]);
    }

    public function getTranslations(int $id): JsonResponse
    {
        $about = $this->aboutService->findById($id);
        $translations = [];

        foreach ($about->translations as $translation) {
            $translations[$translation->lang_code] = [
                'title' => $translation->title,
                'description' => $translation->description
            ];
        }

        return response()->json([
            'success' => true,
            'about' => [
                'id' => $about->id,
                'is_active' => $about->is_active
            ],
            'translations' => $translations
        ]);
    }

    public function store(AboutRequest $request): RedirectResponse
    {
        $this->aboutService->create($request->validated());
        return redirect()->route('abouts.index')->with('success', 'О нас успешно создано');
    }

    public function update(AboutRequest $request, int $id): RedirectResponse
    {
        $this->aboutService->update($id, $request->validated());
        return redirect()->route('abouts.index')->with('success', 'О нас успешно обновлено');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->aboutService->delete($id);
        return redirect()->route('abouts.index')->with('success', 'О нас успешно удалено');
    }
}
