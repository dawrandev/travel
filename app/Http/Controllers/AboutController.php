<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutRequest;
use App\Services\AboutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __construct(
        protected AboutService $aboutService
    ) {}

    public function index(): View
    {
        $abouts = $this->aboutService->getAll();
        return view('pages.abouts.index', compact('abouts'));
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
