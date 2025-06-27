<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            Contact::FIELD_FIRST_NAME => $this->first_name,
            Contact::FIELD_LAST_NAME => $this->last_name,
            Contact::FIELD_EMAIL => $this->email,
            Contact::FIELD_PHONE => $this->phone,
            Contact::FIELD_STREET => $this->street,
            Contact::FIELD_HOUSE_NUMBER => $this->house_number,
            Contact::FIELD_POSTAL_CODE => $this->postal_code,
            Contact::FIELD_CITY => $this->city,
            Contact::FIELD_COUNTRY => $this->country,
            Contact::FIELD_IS_ACTIVE => $this->is_active,
            Contact::FIELD_NOTES => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}