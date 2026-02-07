<?php

namespace App\Services;

use App\Models\Language;
use App\Repositories\ContactRepository;

class ContactService
{
    public function __construct(
        protected ContactRepository $contactRepository
    ) {}

    public function getAll()
    {
        return $this->contactRepository->getAll();
    }

    public function getAllByLanguage(string $langCode)
    {
        $contacts = $this->contactRepository->getAll();

        return $contacts->map(function ($contact) use ($langCode) {
            $translation = $contact->translations->where('lang_code', $langCode)->first();
            return [
                'id' => $contact->id,
                'phone' => $contact->phone,
                'email' => $contact->email,
                'address' => $translation->address ?? 'N/A',
                'longitude' => $contact->longitude,
                'latitude' => $contact->latitude,
                'whatsapp_phone' => $contact->whatsapp_phone, // QOSHILDI
                'telegram_url' => $contact->telegram_url,
                'telegram_username' => $contact->telegram_username,
                'instagram_url' => $contact->instagram_url,
                'facebook_url' => $contact->facebook_url,
                'facebook_name' => $contact->facebook_name, // QOSHILDI
                'youtube_url' => $contact->youtube_url,
            ];
        });
    }

    public function findById(int $id)
    {
        return $this->contactRepository->findById($id);
    }

    public function create(array $data)
    {
        $contact = $this->contactRepository->create($data);

        // Create translations for all languages
        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->contactRepository->createTranslation($contact->id, [
                'address' => $data['address_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $contact;
    }

    public function update(int $id, array $data)
    {
        $contact = $this->contactRepository->findById($id);
        $this->contactRepository->update($contact, $data);

        // Delete old translations and create new ones
        $contact->translations()->delete();

        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->contactRepository->createTranslation($contact->id, [
                'address' => $data['address_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $contact;
    }

    public function delete(int $id)
    {
        $contact = $this->contactRepository->findById($id);
        return $this->contactRepository->delete($contact);
    }
}
