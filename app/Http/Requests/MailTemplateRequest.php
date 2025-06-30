<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\MailTemplate;
use Illuminate\Foundation\Http\FormRequest;

class MailTemplateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            MailTemplate::FIELD_NAME => ['required', 'string', 'max:100'],
            MailTemplate::FIELD_SUBJECT => ['required', 'string', 'max:200'],
            MailTemplate::FIELD_CONTENT => ['required', 'string'],
            MailTemplate::FIELD_DESCRIPTION => ['nullable', 'string'],
            MailTemplate::FIELD_IS_ACTIVE => ['nullable', 'boolean'],
        ];
    }
}