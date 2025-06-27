<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            Task::FIELD_CAMPAIGN_ID => $this->campaign_id,
            Task::FIELD_CONTACT_ID => $this->contact_id,
            Task::FIELD_MAILING_CAMPAIGN_ID => $this->mailing_campaign_id,
            Task::FIELD_TITLE => $this->title,
            Task::FIELD_DESCRIPTION => $this->description,
            Task::FIELD_DUE_DATE => $this->due_date,
            Task::FIELD_PRIORITY => $this->priority,
            Task::FIELD_STATUS => $this->status,
            Task::FIELD_ASSIGNED_TO => $this->assigned_to,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}