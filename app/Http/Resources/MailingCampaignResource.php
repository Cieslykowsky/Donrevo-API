<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\MailingCampaign;
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
            MailingCampaign::FIELD_CAMPAIGN_ID => $this->campaign_id,
            MailingCampaign::FIELD_MAIL_TEMPLATE_ID => $this->mail_template_id,
            MailingCampaign::FIELD_NAME => $this->name,
            MailingCampaign::FIELD_SUBJECT => $this->subject,
            MailingCampaign::FIELD_CONTENT => $this->content,
            MailingCampaign::FIELD_IS_ACTIVE => $this->is_active,
            MailingCampaign::FIELD_SCHEDULED_AT => $this->scheduled_at,
            MailingCampaign::FIELD_SENT_AT => $this->sent_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}