<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailingCampaignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'campaign_id' => 'required|exists:campaigns,id',
            'template_id' => 'nullable|exists:mail_templates,id',
            'name' => 'required|string|max:100',
            'subject' => 'nullable|string|max:200',
            'content' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'scheduled_at' => 'nullable|date',
            'sent_at' => 'nullable|date',
        ];
    }
}