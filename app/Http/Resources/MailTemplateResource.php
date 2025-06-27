<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\MailTemplate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MailTemplateResource extends JsonResource
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
            MailTemplate::FIELD_NAME => $this->name,
            MailTemplate::FIELD_SUBJECT => $this->subject,
            MailTemplate::FIELD_CONTENT => $this->content,
            MailTemplate::FIELD_DESCRIPTION => $this->description,
            MailTemplate::FIELD_IS_ACTIVE => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}