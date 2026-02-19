<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LanguageController extends Controller
{
    public function index(): View
    {
        $languages = Language::paginate(10);
        return view('pages.languages.index', compact('languages'));
    }

    public function show(int $id)
    {
        $language = Language::findOrFail($id);
        return response()->json([
            'success' => true,
            'language' => $language
        ]);
    }

    public function store(LanguageRequest $request): RedirectResponse
    {
        Language::create($request->validated());
        return redirect()->route('languages.index')->with('success', 'Язык успешно добавлен');
    }

    public function update(LanguageRequest $request, int $id): RedirectResponse
    {
        $language = Language::findOrFail($id);
        $language->update($request->validated());
        return redirect()->route('languages.index')->with('success', 'Язык успешно обновлен');
    }

    public function destroy(int $id): RedirectResponse
    {
        Language::findOrFail($id)->delete();
        return redirect()->route('languages.index')->with('success', 'Язык успешно удален');
    }
}
