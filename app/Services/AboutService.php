<?php

namespace App\Services;

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

    public function findById(int $id)
    {
        return $this->aboutRepository->findById($id);
    }

    public function create(array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('about', 'public');
        }

        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        $about = $this->aboutRepository->create($data);

        $this->aboutRepository->createTranslation($about->id, [
            'title' => $data['title'],
            'description' => $data['description'],
            'lang_code' => 'ru',
        ]);

        return $about;
    }

    public function update(int $id, array $data)
    {
        $about = $this->aboutRepository->findById($id);

        if (isset($data['image'])) {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $data['image'] = $data['image']->store('about', 'public');
        }

        $data['is_active'] = isset($data['is_active']) ? 1 : 0;

        $this->aboutRepository->update($about, $data);

        $this->aboutRepository->createTranslation($about->id, [
            'title' => $data['title'],
            'description' => $data['description'],
            'lang_code' => 'ru',
        ]);

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
