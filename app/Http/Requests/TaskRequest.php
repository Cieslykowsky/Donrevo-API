<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

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
            Task::FIELD_CAMPAIGN_ID => 'nullable|exists:campaigns,id',
            Task::FIELD_CONTACT_ID => 'nullable|exists:contacts,id',
            Task::FIELD_MAILING_CAMPAIGN_ID => 'nullable|exists:mailing_campaigns,id',
            Task::FIELD_TITLE => 'required|string|max:200',
            Task::FIELD_DESCRIPTION => 'nullable|string',
            Task::FIELD_DUE_DATE => 'nullable|date',
            Task::FIELD_PRIORITY => 'required|in:low,medium,high',
            Task::FIELD_STATUS => 'required|in:todo,in_progress,on_hold,cancelled,ready_for_review,in_review,approved,rejected,deferred,testing,completed',
            Task::FIELD_ASSIGNED_TO => 'nullable|exists:users,id',
        ];
    }
}