<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactBannerRequest;
use App\Http\Requests\ContactRequest;
use App\Models\ContactBanner;
use App\Models\Language;
use App\Services\ContactBannerService;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct(
        protected ContactService $contactService,
        protected ContactBannerService $contactBannerService
    ) {}

    public function index(): View
    {
        $contacts = $this->contactService->getAll();
        $banner = ContactBanner::first();
        $languages = Language::all();
        return view('pages.contacts.index', compact('contacts', 'banner', 'languages'));
    }

    public function filter(Request $request): JsonResponse
    {
        $langCode = $request->get('lang_code', 'en');
        $contacts = $this->contactService->getAllByLanguage($langCode);

        return response()->json([
            'success' => true,
            'data' => $contacts
        ]);
    }

    public function getTranslations(int $id): JsonResponse
    {
        $contact = $this->contactService->findById($id);
        $translations = [];

        foreach ($contact->translations as $translation) {
            $translations[$translation->lang_code] = [
                'address' => $translation->address,
            ];
        }

        return response()->json([
            'success' => true,
            'contact' => [
                'id' => $contact->id,
                'phone' => $contact->phone,
                'email' => $contact->email,
                'longitude' => $contact->longitude,
                'latitude' => $contact->latitude,
                'whatsapp_phone' => $contact->whatsapp_phone,
                'telegram_url' => $contact->telegram_url,
                'telegram_username' => $contact->telegram_username,
                'instagram_url' => $contact->instagram_url,
                'instagram_username' => $contact->instagram_username,
                'facebook_url' => $contact->facebook_url,
                'facebook_name' => $contact->facebook_name,
                'youtube_url' => $contact->youtube_url,
            ],
            'translations' => $translations
        ]);
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        $this->contactService->create($request->validated());
        return redirect()->route('contacts.index')->with('success', 'Контакт успешно создан');
    }

    public function update(ContactRequest $request, int $id): RedirectResponse
    {
        $this->contactService->update($id, $request->validated());
        return redirect()->route('contacts.index')->with('success', 'Контакт успешно обновлен');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->contactService->delete($id);
        return redirect()->route('contacts.index')->with('success', 'Контакт успешно удален');
    }

    public function storeBanner(ContactBannerRequest $request): RedirectResponse
    {
        $this->contactBannerService->create($request->validated());
        return redirect()->route('contacts.index')->with('success', 'Баннер успешно создан');
    }

    public function updateBanner(ContactBannerRequest $request, int $id): RedirectResponse
    {
        $this->contactBannerService->update($id, $request->validated());
        return redirect()->route('contacts.index')->with('success', 'Баннер успешно обновлен');
    }

    public function getBannerTranslations(int $id): JsonResponse
    {
        $banner = $this->contactBannerService->findById($id);

        $translations = [];
        foreach ($banner->translations as $translation) {
            $translations[$translation->lang_code] = [
                'title' => $translation->title,
            ];
        }

        $images = $banner->images->sortBy('sort_order')->map(function ($image) {
            return [
                'id' => $image->id,
                'image_path' => $image->image_path,
                'sort_order' => $image->sort_order,
            ];
        })->values()->toArray();

        return response()->json([
            'success' => true,
            'banner' => [
                'id' => $banner->id,
                'is_active' => $banner->is_active
            ],
            'translations' => $translations,
            'images' => $images
        ]);
    }
}
