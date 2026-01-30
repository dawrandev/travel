<?php

namespace App\Http\Controllers;

use App\Http\Requests\HeroSlideRequest;
use App\Services\HeroSlideService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    public function __construct(
        protected HeroSlideService $heroSlideService
    ) {}

    public function index(): View
    {
        $heroSlides = $this->heroSlideService->getAll();
        return view('pages.hero-slides.index', compact('heroSlides'));
    }

    public function store(HeroSlideRequest $request): RedirectResponse
    {
        $this->heroSlideService->create($request->validated());
        return redirect()->route('hero-slides.index')->with('success', 'Слайд успешно создан');
    }

    public function update(HeroSlideRequest $request, int $id): RedirectResponse
    {
        $this->heroSlideService->update($id, $request->validated());
        return redirect()->route('hero-slides.index')->with('success', 'Слайд успешно обновлен');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->heroSlideService->delete($id);
        return redirect()->route('hero-slides.index')->with('success', 'Слайд успешно удален');
    }
}
