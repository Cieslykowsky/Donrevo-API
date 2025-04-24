<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CampaignRequest;
use App\Http\Resources\CampaignResource;
use App\Models\Campaign;

class CampaignController extends Controller
{
    public function index(): ResourceCollection
    {
        $campaigns = Campaign::all();
        return CampaignResource::collection($campaigns);
    }

    public function store(CampaignRequest $request): CampaignResource
    {
        $validated = $request->validated();

        $campaign = Campaign::create($validated);

        return CampaignResource::make($campaign);
    }

    public function show(Campaign $campaign): CampaignResource
    {
        return CampaignResource::make($campaign);
    }

    public function update(CampaignRequest $request, Campaign $campaign): CampaignResource
    {
        $validated = $request->validated();

        $campaign->update($validated);

        return CampaignResource::make($campaign);
    }

    public function destroy(Campaign $campaign): JsonResponse
    {
        $campaign->delete();

        return response()->json(null, 204);
    }
}