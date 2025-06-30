<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\MailingCampaign;
use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
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
            Task::FIELD_CAMPAIGN_ID => ['nullable', Rule::exists(Campaign::TABLE, 'id')],
            Task::FIELD_CONTACT_ID => ['nullable', Rule::exists(Contact::TABLE, 'id')],
            Task::FIELD_MAILING_CAMPAIGN_ID => ['nullable', Rule::exists(MailingCampaign::TABLE, 'id')],
            Task::FIELD_TITLE => ['required', 'string', 'max:200'],
            Task::FIELD_DESCRIPTION => ['nullable', 'string'],
            Task::FIELD_DUE_DATE => ['nullable', 'date'],
            Task::FIELD_PRIORITY => ['required', Rule::enum(TaskPriority::class)],
            Task::FIELD_STATUS => ['required', Rule::enum(TaskStatus::class)],
            Task::FIELD_ASSIGNED_TO => ['nullable', Rule::exists('users', 'id')],
        ];
    }
}