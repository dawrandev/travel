<?php

namespace App\Services;

use App\Models\Language;
use App\Repositories\AboutRepository;
use Illuminate\Support\Facades\Storage;

class AboutService
{
    public function __construct(
        protected AboutRepository $aboutRepository
    ) {}

    public function getAll()
    {
        return $this->aboutRepository->getAll();
    }

    public function getAllByLanguage(string $langCode)
    {
        $abouts = $this->aboutRepository->getAll();

        return $abouts->map(function ($about) use ($langCode) {
            $translation = $about->translations->where('lang_code', $langCode)->first();
            return [
                'id' => $about->id,
                'title' => $translation->title ?? 'N/A',
                'description' => $translation->description ?? 'N/A',
                'image' => $about->image,
                'is_active' => $about->is_active
            ];
        });
    }

    public function findById(int $id)
    {
        return $this->aboutRepository->findById($id);
    }

    public function create(array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('uploads', 'public');
        }

        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        $about = $this->aboutRepository->create($data);

        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->aboutRepository->createTranslation($about->id, [
                'title' => $data['title_' . $langCode] ?? '',
                'description' => $data['description_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $about;
    }

    public function update(int $id, array $data)
    {
        $about = $this->aboutRepository->findById($id);

        if (isset($data['image'])) {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $data['image'] = $data['image']->store('uploads', 'public');
        }

        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        $this->aboutRepository->update($about, $data);

        $about->translations()->delete();

        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->aboutRepository->createTranslation($about->id, [
                'title' => $data['title_' . $langCode] ?? '',
                'description' => $data['description_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $about;
    }

    public function delete(int $id)
    {
        $about = $this->aboutRepository->findById($id);

        if ($about->image) {
            Storage::disk('public')->delete($about->image);
        }

        return $this->aboutRepository->delete($about);
    }
}
