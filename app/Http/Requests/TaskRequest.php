<?php

namespace App\Http\Requests;

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
            'campaign_id' => 'nullable|exists:campaigns,id',
            'contact_id' => 'nullable|exists:contacts,id',
            'mailing_campaign_id' => 'nullable|exists:mailing_campaigns,id',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:todo,in_progress,on_hold,cancelled,ready_for_review,in_review,approved,rejected,deferred,testing,completed',
            'assigned_to' => 'nullable|exists:users,id',
        ];
    }
}