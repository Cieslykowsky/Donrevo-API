<?php
declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
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
            Contact::FIELD_FIRST_NAME => ['nullable', 'string', 'max:50'],
            Contact::FIELD_LAST_NAME => ['nullable', 'string', 'max:50'],
            Contact::FIELD_EMAIL => [
                'required',
                'email',
                Rule::unique(Contact::TABLE, Contact::FIELD_EMAIL)->ignore($this->route('contact')),
            ],
            Contact::FIELD_PHONE => ['nullable', 'string', 'max:20'],
            Contact::FIELD_STREET => ['nullable', 'string', 'max:255'],
            Contact::FIELD_HOUSE_NUMBER => ['nullable', 'string', 'max:50'],
            Contact::FIELD_POSTAL_CODE => ['nullable', 'string', 'max:20'],
            Contact::FIELD_CITY => ['nullable', 'string', 'max:100'],
            Contact::FIELD_COUNTRY => ['nullable', 'string', 'max:100'],
            Contact::FIELD_IS_ACTIVE => ['nullable', 'boolean'],
            Contact::FIELD_NOTES => ['nullable', 'string'],
        ];
    }
}