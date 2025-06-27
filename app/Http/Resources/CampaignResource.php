<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            Campaign::FIELD_GROUP_ID => $this->group_id,
            Campaign::FIELD_NAME => $this->name,
            Campaign::FIELD_DESCRIPTION => $this->description,
            Campaign::FIELD_IS_ACTIVE => $this->is_active,
            Campaign::FIELD_START_DATE => $this->start_date,
            Campaign::FIELD_END_DATE => $this->end_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}