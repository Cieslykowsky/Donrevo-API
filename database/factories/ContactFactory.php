<?php

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
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'street' => $this->faker->optional()->streetName(),
            'house_number' => $this->faker->optional()->buildingNumber(),
            'postal_code' => $this->faker->optional()->postcode(),
            'city' => $this->faker->optional()->city(),
            'country' => $this->faker->optional()->country(),
            'is_active' => $this->faker->boolean(90),
            'notes' => $this->faker->optional()->text(200),
        ];
    }
}
