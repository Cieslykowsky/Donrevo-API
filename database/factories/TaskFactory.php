<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\MailingCampaign;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dueDate = $this->faker->optional(0.7)->dateTimeBetween('-1 week', '+2 months');

        return [
            'campaign_id' => Campaign::inRandomOrder()->first()?->id,
            'contact_id' => Contact::inRandomOrder()->first()?->id,
            'mailing_campaign_id' => MailingCampaign::inRandomOrder()->first()?->id,
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->optional()->paragraphs(3, true),
            'due_date' => $dueDate,
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'status' => $this->faker->randomElement([
                'todo', 'in_progress', 'on_hold', 'cancelled', 'ready_for_review',
                'in_review', 'approved', 'rejected', 'deferred', 'testing', 'completed'
            ]),
            'assigned_to' => User::inRandomOrder()->first()?->id,
        ];
    }
}
