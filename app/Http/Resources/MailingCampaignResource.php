<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MailingCampaignResource extends JsonResource
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
            'campaign_id' => $this->campaign_id,
            'template_id' => $this->template_id,
            'name' => $this->name,
            'subject' => $this->subject,
            'content' => $this->content,
            'is_active' => $this->is_active,
            'scheduled_at' => optional($this->scheduled_at)->toDateTimeString(),
            'sent_at' => optional($this->sent_at)->toDateTimeString(),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}