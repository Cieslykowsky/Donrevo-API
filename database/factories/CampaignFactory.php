<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    protected $model = Campaign::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-5 years', 'now');
        
        $endDate = $this->faker->dateTimeBetween($startDate, '+3 years');

        return [
            Campaign::FIELD_GROUP_ID => Group::inRandomOrder()->first()->id,
            Campaign::FIELD_NAME => $this->faker->word(),
            Campaign::FIELD_DESCRIPTION => $this->faker->text(),
            Campaign::FIELD_IS_ACTIVE => $this->faker->boolean(),
            Campaign::FIELD_START_DATE => $startDate->format('Y-m-d'),
            Campaign::FIELD_END_DATE => $endDate->format('Y-m-d'),
        ];
    }
}
