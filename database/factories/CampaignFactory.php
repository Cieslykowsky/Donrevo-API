<?php

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
            'group_id' => Group::inRandomOrder()->first()->id,
            'name' => $this->faker->word(),
            'description' => $this->faker->text(),
            'is_active' => $this->faker->boolean(),
            'start_date' => $startDate,
            'end_date' => $endDate->format('Y-m-d'),
        ];
    }
}
