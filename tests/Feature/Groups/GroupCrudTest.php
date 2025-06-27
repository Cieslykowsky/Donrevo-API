<?php
declare(strict_types=1);

namespace Tests\Feature\Groups;

use Tests\TestCase;
use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateGroup(): void
    {
        $group = Group::factory()->make()->toArray();
        
        $response = $this->postJson('/api/groups', $group);
        
        $response->assertStatus(201);
        $response->assertJsonFragment([
            Group::FIELD_NAME => $group[Group::FIELD_NAME],
            Group::FIELD_DESCRIPTION => $group[Group::FIELD_DESCRIPTION],
        ]);
        $this->assertDatabaseHas(Group::TABLE, $group);
    }

    public function testCannotCreateGroupWithInvalidData(): void
    {
        $response = $this->postJson('/api/groups', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(Group::FIELD_NAME);
    }

    public function testCanListGroups(): void
    {
        $groups = Group::factory()->count(4)->create();
        $response = $this->getJson('/api/groups');

        $response->assertStatus(200);
        $responseData = $response->json('data');

        $this->assertCount(4, $responseData);
        $this->assertEquals(
            $groups->pluck('id')->sort()->values()->toArray(),
            collect($responseData)->pluck('id')->sort()->values()->toArray()
        );
    }

    public function testCanShowGroup(): void
    {
        $group = Group::factory()->create();

        $response = $this->getJson("/api/groups/{$group->id}");

        $response->assertStatus(200);
        $responseData = $response->json('data');

        $this->assertEquals(
            $group->only(Group::FIELDS),
            collect($responseData)->only(Group::FIELDS)->toArray()
        );
    }

    public function testCannotShowNonExistentGroup(): void
    {
        $response = $this->getJson('/api/groups/9999999');

        $response->assertStatus(404);
    }

    public function testCanUpdateGroup(): void
    {
        $group = Group::factory()->create();

        $updatedData = [
            Group::FIELD_NAME => 'Updated Group Name',
            Group::FIELD_DESCRIPTION => 'Updated description',
        ];

        $response = $this->putJson("/api/groups/{$group->id}", $updatedData);

        $response->assertStatus(200);

        $responseData = $response->json('data');
        $this->assertEquals(
            collect($updatedData)->only(Group::FIELDS)->toArray(),
            collect($responseData)->only(Group::FIELDS)->toArray()
        );

        $this->assertDatabaseHas(Group::TABLE, array_merge(['id' => $group->id], $updatedData));
    }

    public function testCannotUpdateGroupWithInvalidData(): void
    {
        $group = Group::factory()->create();

        $invalidData = [
            Group::FIELD_NAME => null,
        ];

        $response = $this->putJson("/api/groups/{$group->id}", $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            Group::FIELD_NAME,
        ]);
    }

    public function testCanDeleteGroup(): void
    {
        $group = Group::factory()->create();

        $response = $this->deleteJson("/api/groups/{$group->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing(Group::TABLE, ['id' => $group->id]);
    }    
}