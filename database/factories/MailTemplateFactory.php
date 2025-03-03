<?php

namespace Database\Factories;

use App\Models\MailTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class MailTemplateFactory extends Factory
{
    protected $model = MailTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(3, true),
            'subject' => $this->faker->sentence(6),
            'content' => $this->faker->paragraphs(3, true),
            'description' => $this->faker->optional()->sentence(10),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
