<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index(): ResourceCollection
    {
        $contacts = Contact::all();
        return ContactResource::collection($contacts);
    }

    public function store(ContactRequest $request): ContactResource
    {
        $validated = $request->validated();
        $contact = Contact::create($validated);

        return ContactResource::make($contact);
    }

    public function show(Contact $contact): ContactResource
    {
        return ContactResource::make($contact);
    }

    public function update(ContactRequest $request, Contact $contact): ContactResource
    {
        $validated = $request->validated();
        $contact->update($validated);

        return ContactResource::make($contact);
    }

    public function destroy(Contact $contact): JsonResponse
    {
        $contact->delete();

        return response()->json(null, 204);
    }
}