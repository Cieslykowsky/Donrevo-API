<?php

namespace Database\Factories;

use App\Models\MailingCampaign;
use App\Models\Campaign;
use App\Models\MailTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class MailingCampaignFactory extends Factory
{
    protected $model = MailingCampaign::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');

        $endDate = $this->faker->dateTimeBetween($startDate, '+1 month');

        return [
            'campaign_id' => Campaign::inRandomOrder()->first()?->id,
            'template_id' => MailTemplate::inRandomOrder()->first()?->id,
            'name' => $this->faker->sentence(3),
            'subject' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'is_active' => $this->faker->boolean(80),
            'scheduled_at' => $startDate,
            'sent_at' => $endDate,
        ];
    }
}
