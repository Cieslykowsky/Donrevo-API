<?php
declare(strict_types=1);

namespace Tests\Feature\Tasks;

use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Group;
use App\Models\MailingCampaign;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function createRelatedRecordsForMailingCampaign(): array
    {
        $group = Group::factory()->create();
        $campaign = Campaign::factory()->create([Campaign::FIELD_GROUP_ID => $group->id]);
        $contact = Contact::factory()->create();
        $mailingCampaign = MailingCampaign::factory()->create();
        $user = User::factory()->create();
        
        return [
            Task::FIELD_CAMPAIGN_ID => $campaign->id,
            Task::FIELD_CONTACT_ID => $contact->id,
            Task::FIELD_MAILING_CAMPAIGN_ID => $mailingCampaign->id,
            Task::FIELD_ASSIGNED_TO => $user->id,
        ];
    }

    protected function createTaskWithRelatedRecords(): Task
    {
        $relatedRecords = $this->createRelatedRecordsForMailingCampaign();
        $task = Task::factory()->create([
            Task::FIELD_CAMPAIGN_ID => $relatedRecords[Task::FIELD_CAMPAIGN_ID],
            Task::FIELD_CONTACT_ID => $relatedRecords[Task::FIELD_CONTACT_ID],
            Task::FIELD_MAILING_CAMPAIGN_ID => $relatedRecords[Task::FIELD_MAILING_CAMPAIGN_ID],
            Task::FIELD_ASSIGNED_TO => $relatedRecords[Task::FIELD_ASSIGNED_TO],
        ]);

        return $task;
    }

    public function testCanCreateTask(): void
    {
        $relatedRecords = $this->createRelatedRecordsForMailingCampaign();
        $task = Task::factory()->make([
            Task::FIELD_CAMPAIGN_ID => $relatedRecords[Task::FIELD_CAMPAIGN_ID],
            Task::FIELD_CONTACT_ID => $relatedRecords[Task::FIELD_CONTACT_ID],
            Task::FIELD_MAILING_CAMPAIGN_ID => $relatedRecords[Task::FIELD_MAILING_CAMPAIGN_ID],
            Task::FIELD_ASSIGNED_TO => $relatedRecords[Task::FIELD_ASSIGNED_TO],
        ])->toArray();

        $response = $this->postJson('/api/tasks', $task);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            Task::FIELD_CAMPAIGN_ID => $task[Task::FIELD_CAMPAIGN_ID],
            Task::FIELD_CONTACT_ID => $task[Task::FIELD_CONTACT_ID],
            Task::FIELD_MAILING_CAMPAIGN_ID => $task[Task::FIELD_MAILING_CAMPAIGN_ID],
            Task::FIELD_TITLE => $task[Task::FIELD_TITLE],
            Task::FIELD_DESCRIPTION => $task[Task::FIELD_DESCRIPTION],
            Task::FIELD_DUE_DATE => $task[Task::FIELD_DUE_DATE],
            Task::FIELD_PRIORITY => $task[Task::FIELD_PRIORITY],
            Task::FIELD_STATUS => $task[Task::FIELD_STATUS],
            Task::FIELD_ASSIGNED_TO => $task[Task::FIELD_ASSIGNED_TO],
        ]);

        $this->assertDatabaseHas(Task::TABLE, $task);
    }

    public function testCannotCreateTaskWithInvalidData(): void
    {
        $response = $this->postJson('/api/tasks', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            Task::FIELD_TITLE,
            Task::FIELD_TITLE,
            Task::FIELD_STATUS,
        ]);
    }

    public function testCanListTasks(): void
    {
        $relatedRecords = $this->createRelatedRecordsForMailingCampaign();
        $tasks = Task::factory()->count(4)->create([
            Task::FIELD_CAMPAIGN_ID => $relatedRecords[Task::FIELD_CAMPAIGN_ID],
            Task::FIELD_CONTACT_ID => $relatedRecords[Task::FIELD_CONTACT_ID],
            Task::FIELD_MAILING_CAMPAIGN_ID => $relatedRecords[Task::FIELD_MAILING_CAMPAIGN_ID],
            Task::FIELD_ASSIGNED_TO => $relatedRecords[Task::FIELD_ASSIGNED_TO],
        ]);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200);

       $responseData = $response->json('data');
        $this->assertCount(4, $responseData);
        $this->assertEquals(
            $tasks->pluck('id')->sort()->values()->toArray(),
            collect($responseData)->pluck('id')->sort()->values()->toArray()
        );
    }

    public function testCanShowTask(): void
    {
        $task = $this->createTaskWithRelatedRecords();

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200);

        $responseData = $response->json('data');
        
        $this->assertEquals(
            $task->only(Task::FIELDS),
            collect($responseData)->only(Task::FIELDS)->toArray()
        );
    }

    public function testCannotShowNonExistentTask(): void
    {
        $response = $this->getJson('/api/tasks/9999999');

        $response->assertStatus(404);
    }

    public function testCanUpdateTask(): void
    {
        $task = $this->createTaskWithRelatedRecords();

        $updatedData = [
            Task::FIELD_CAMPAIGN_ID => $task[Task::FIELD_CAMPAIGN_ID],
            Task::FIELD_CONTACT_ID => $task[Task::FIELD_CONTACT_ID],
            Task::FIELD_MAILING_CAMPAIGN_ID => $task[Task::FIELD_MAILING_CAMPAIGN_ID],
            Task::FIELD_TITLE => 'Updated Title',
            Task::FIELD_DESCRIPTION => 'Updated Description',
            Task::FIELD_DUE_DATE => '2030-01-01 12:00:00',
            Task::FIELD_PRIORITY => $task[Task::FIELD_PRIORITY],
            Task::FIELD_STATUS => $task[Task::FIELD_STATUS],
            Task::FIELD_ASSIGNED_TO => $task[Task::FIELD_ASSIGNED_TO],
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $updatedData);

        $response->assertStatus(200);

        $responseData = $response->json('data');
        $this->assertEquals(
            collect($updatedData)->only(Task::FIELDS)->toArray(),
            collect($responseData)->only(Task::FIELDS)->toArray()
        );

        $this->assertDatabaseHas(Task::TABLE, array_merge(['id' => $task->id], $updatedData));
    }

    public function testCannotUpdateTaskWithInvalidData(): void
    {
        $task = $this->createTaskWithRelatedRecords();

        $invalidData = [
            Task::FIELD_TITLE => null,
            Task::FIELD_PRIORITY => 'invalid_priority',
            Task::FIELD_STATUS => 'invalid_status',
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            Task::FIELD_TITLE,
            Task::FIELD_PRIORITY,
            Task::FIELD_STATUS,
        ]);
    }

    public function testCanDeleteTask(): void
    {
        $task = $this->createTaskWithRelatedRecords();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing(Task::TABLE, ['id' => $task->id]);
    }
}