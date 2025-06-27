<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            Contact::FIELD_FIRST_NAME => $this->faker->firstName(),
            Contact::FIELD_LAST_NAME => $this->faker->lastName(),
            Contact::FIELD_EMAIL => $this->faker->unique()->safeEmail(),
            Contact::FIELD_PHONE => $this->faker->optional()->phoneNumber(),
            Contact::FIELD_STREET => $this->faker->optional()->streetName(),
            Contact::FIELD_HOUSE_NUMBER => $this->faker->optional()->buildingNumber(),
            Contact::FIELD_POSTAL_CODE => $this->faker->optional()->postcode(),
            Contact::FIELD_CITY => $this->faker->optional()->city(),
            Contact::FIELD_COUNTRY => $this->faker->optional()->country(),
            Contact::FIELD_IS_ACTIVE => $this->faker->boolean(90),
            Contact::FIELD_NOTES => $this->faker->optional()->text(200),
        ];
    }
}
