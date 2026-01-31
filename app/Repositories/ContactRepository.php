<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Models\ContactTranslation;

class ContactRepository
{
    public function getAll()
    {
        return Contact::with('translations')->latest()->get();
    }

    public function findById(int $id)
    {
        return Contact::with('translations')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Contact::create($data);
    }

    public function update(Contact $contact, array $data)
    {
        $contact->update($data);
        return $contact;
    }

    public function delete(Contact $contact)
    {
        return $contact->delete();
    }

    public function createTranslation(int $contactId, array $data)
    {
        return ContactTranslation::create(array_merge($data, ['contact_id' => $contactId]));
    }
}
