<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\MailingCampaign;
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
            MailingCampaign::FIELD_CAMPAIGN_ID => 'required|exists:campaigns,id',
            MailingCampaign::FIELD_MAIL_TEMPLATE_ID => 'nullable|exists:mail_templates,id',
            MailingCampaign::FIELD_NAME => 'required|string|max:100',
            MailingCampaign::FIELD_SUBJECT => 'nullable|string|max:200',
            MailingCampaign::FIELD_CONTENT => 'nullable|string',
            MailingCampaign::FIELD_IS_ACTIVE => 'nullable|boolean',
            MailingCampaign::FIELD_SCHEDULED_AT => 'nullable|date',
            MailingCampaign::FIELD_SENT_AT => 'nullable|date',
        ];
    }
}