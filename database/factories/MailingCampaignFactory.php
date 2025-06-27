<?php
declare(strict_types=1);

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
            MailingCampaign::FIELD_CAMPAIGN_ID => Campaign::inRandomOrder()->first()?->id,
            MailingCampaign::FIELD_MAIL_TEMPLATE_ID => MailTemplate::inRandomOrder()->first()?->id,
            MailingCampaign::FIELD_NAME => $this->faker->sentence(3),
            MailingCampaign::FIELD_SUBJECT => $this->faker->sentence(),
            MailingCampaign::FIELD_CONTENT => $this->faker->paragraphs(3, true),
            MailingCampaign::FIELD_IS_ACTIVE => $this->faker->boolean(80),
            MailingCampaign::FIELD_SCHEDULED_AT => $startDate->format('Y-m-d H:i:s'),
            MailingCampaign::FIELD_SENT_AT => $endDate->format('Y-m-d H:i:s'),
        ];
    }
}
