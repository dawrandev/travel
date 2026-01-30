<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaqRequest;
use App\Services\FaqService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function __construct(
        protected FaqService $faqService
    ) {}

    public function index(): View
    {
        $faqs = $this->faqService->getAll();
        return view('pages.faqs.index', compact('faqs'));
    }

    public function store(FaqRequest $request): RedirectResponse
    {
        $this->faqService->create($request->validated());
        return redirect()->route('faqs.index')->with('success', 'Вопрос успешно создан');
    }

    public function update(FaqRequest $request, int $id): RedirectResponse
    {
        $this->faqService->update($id, $request->validated());
        return redirect()->route('faqs.index')->with('success', 'Вопрос успешно обновлен');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->faqService->delete($id);
        return redirect()->route('faqs.index')->with('success', 'Вопрос успешно удален');
    }
}
