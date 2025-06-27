<?php
declare(strict_types=1);

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
            Task::FIELD_CAMPAIGN_ID => Campaign::inRandomOrder()->first()?->id,
            Task::FIELD_CONTACT_ID => Contact::inRandomOrder()->first()?->id,
            Task::FIELD_MAILING_CAMPAIGN_ID => MailingCampaign::inRandomOrder()->first()?->id,
            Task::FIELD_TITLE => $this->faker->sentence(4),
            Task::FIELD_DESCRIPTION => $this->faker->optional()->paragraphs(3, true),
            Task::FIELD_DUE_DATE => $dueDate ? $dueDate->format('Y-m-d H:i:s') : null,
            Task::FIELD_PRIORITY => $this->faker->randomElement(['low', 'medium', 'high']),
            Task::FIELD_STATUS => $this->faker->randomElement([
                'todo', 'in_progress', 'on_hold', 'cancelled', 'ready_for_review',
                'in_review', 'approved', 'rejected', 'deferred', 'testing', 'completed'
            ]),
            Task::FIELD_ASSIGNED_TO => User::inRandomOrder()->first()?->id,
        ];
    }
}
