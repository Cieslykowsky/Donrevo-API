<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\MailTemplateRequest;
use App\Http\Resources\MailTemplateResource;
use App\Models\MailTemplate;

class MailTemplateController extends Controller
{
    public function index(): ResourceCollection
    {
        return MailTemplateResource::collection(MailTemplate::all());
    }

    public function store(MailTemplateRequest $request): MailTemplateResource
    {
        $validated = $request->validated();
        $mailTemplate = MailTemplate::create($validated);

        return MailTemplateResource::make($mailTemplate);
    }

    public function show(MailTemplate $mailTemplate): MailTemplateResource
    {
        return MailTemplateResource::make($mailTemplate);
    }

    public function update(MailTemplateRequest $request, MailTemplate $mailTemplate): MailTemplateResource
    {
        $validated = $request->validated();
        $mailTemplate->update($validated);

        return MailTemplateResource::make($mailTemplate);
    }

    public function destroy(MailTemplate $mailTemplate): JsonResponse
    {
        $mailTemplate->delete();

        return response()->json(null, 204);
    }
}