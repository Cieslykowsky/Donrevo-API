<?php
declare(strict_types=1);

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
            MailTemplate::FIELD_NAME => $this->faker->unique()->words(3, true),
            MailTemplate::FIELD_SUBJECT => $this->faker->sentence(6),
            MailTemplate::FIELD_CONTENT => $this->faker->paragraphs(3, true),
            MailTemplate::FIELD_DESCRIPTION => $this->faker->optional()->sentence(10),
            MailTemplate::FIELD_IS_ACTIVE => $this->faker->boolean(90),
        ];
    }
}
