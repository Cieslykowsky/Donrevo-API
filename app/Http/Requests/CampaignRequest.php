<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Campaign;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CampaignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            Campaign::FIELD_GROUP_ID => ['required', 'integer', Rule::exists('groups', 'id')],
            Campaign::FIELD_NAME => ['required', 'string', 'max:100'],
            Campaign::FIELD_DESCRIPTION => ['nullable', 'string'],
            Campaign::FIELD_IS_ACTIVE => ['boolean'],
            Campaign::FIELD_START_DATE => ['nullable', 'date'],
            Campaign::FIELD_END_DATE => ['nullable', 'date', 'after_or_equal:start_date'],
        ];
    }
}