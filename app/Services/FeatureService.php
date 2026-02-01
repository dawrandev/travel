<?php

namespace App\Services;

use App\Models\Language;
use App\Repositories\FeatureRepository;
use Illuminate\Support\Facades\Storage;

class FeatureService
{
    public function __construct(
        protected FeatureRepository $featureRepository
    ) {}

    public function getAll()
    {
        return $this->featureRepository->getAll();
    }

    public function getAllByLanguage(string $langCode)
    {
        $features = $this->featureRepository->getAll();

        return $features->map(function ($feature) use ($langCode) {
            $translation = $feature->translations->where('lang_code', $langCode)->first();
            return [
                'id' => $feature->id,
                'icon' => $feature->icon,
                'name' => $translation->name ?? 'N/A',
                'description' => $translation->description ?? 'N/A',
            ];
        });
    }

    public function findById(int $id)
    {
        return $this->featureRepository->findById($id);
    }

    public function create(array $data)
    {
        $feature = $this->featureRepository->create($data);

        // Create translations for all languages
        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->featureRepository->createTranslation($feature->id, [
                'name' => $data['name_' . $langCode] ?? '',
                'description' => $data['description_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $feature;
    }

    public function update(int $id, array $data)
    {
        $feature = $this->featureRepository->findById($id);

        $this->featureRepository->update($feature, $data);

        $feature->translations()->delete();

        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->featureRepository->createTranslation($feature->id, [
                'name' => $data['name_' . $langCode] ?? '',
                'description' => $data['description_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $feature;
    }

    public function delete(int $id)
    {
        $feature = $this->featureRepository->findById($id);

        return $this->featureRepository->delete($feature);
    }
}
