<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\MailingCampaignRequest;
use App\Http\Resources\MailingCampaignResource;
use App\Models\MailingCampaign;

class MailingCampaignController extends Controller
{
    public function index(): ResourceCollection
    {
        $mailingCampaigns = MailingCampaign::all();
        return MailingCampaignResource::collection($mailingCampaigns);
    }

    public function store(MailingCampaignRequest $request): MailingCampaignResource 
    {
        $validated = $request->validated();
        $mailingCampaign = MailingCampaign::create($validated);

        return MailingCampaignResource::make($mailingCampaign);
    }

    public function show(MailingCampaign $mailingCampaign): MailingCampaignResource
    {
        return MailingCampaignResource::make($mailingCampaign);
    }

    public function update(MailingCampaignRequest $request, MailingCampaign $mailingCampaign): MailingCampaignResource
    {
        $validated = $request->validated();
        $mailingCampaign->update($validated);

        return MailingCampaignResource::make($mailingCampaign);
    }

    public function destroy(MailingCampaign $mailingCampaign): JsonResponse
    {
        $mailingCampaign->delete();

        return response()->json(null, 204);
    }
}