<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeatureRequest;
use App\Models\Language;
use App\Services\FeatureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeatureController extends Controller
{
    public function __construct(
        protected FeatureService $featureService
    ) {}

    public function index(): View
    {
        $features = $this->featureService->getAll();
        $languages = Language::all();
        return view('pages.features.index', compact('features', 'languages'));
    }

    public function filter(Request $request): JsonResponse
    {
        $langCode = $request->get('lang_code', 'en');
        $features = $this->featureService->getAllByLanguage($langCode);

        return response()->json([
            'success' => true,
            'data' => $features
        ]);
    }

    public function getTranslations(int $id): JsonResponse
    {
        $feature = $this->featureService->findById($id);
        $translations = [];

        foreach ($feature->translations as $translation) {
            $translations[$translation->lang_code] = [
                'name' => $translation->name,
                'description' => $translation->description
            ];
        }

        return response()->json([
            'success' => true,
            'feature' => [
                'id' => $feature->id,
                'icon' => $feature->icon,
            ],
            'translations' => $translations
        ]);
    }

    public function store(StoreFeatureRequest $request): RedirectResponse
    {
        $this->featureService->create($request->validated());
        return redirect()->route('features.index')->with('success', 'Функция успешно создана');
    }

    public function update(StoreFeatureRequest $request, int $id): RedirectResponse
    {
        $this->featureService->update($id, $request->validated());
        return redirect()->route('features.index')->with('success', 'Функция успешно обновлена');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->featureService->delete($id);
        return redirect()->route('features.index')->with('success', 'Функция успешно удалена');
    }
}
