<?php
declare(strict_types=1);

namespace Tests\Feature\Campaigns;

use Tests\TestCase;
use App\Models\Campaign;
use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CampaignCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateCampaign(): void
    {
        $group = Group::factory()->create();
        $campaign = Campaign::factory()->make([Campaign::FIELD_GROUP_ID => $group->id])->toArray();

        $response = $this->postJson('/api/campaigns', $campaign);
        
        $response->assertStatus(201);
        $response->assertJsonFragment([
           Campaign::FIELD_GROUP_ID => $campaign[Campaign::FIELD_GROUP_ID],
           Campaign::FIELD_NAME => $campaign[Campaign::FIELD_NAME],
           Campaign::FIELD_DESCRIPTION => $campaign[Campaign::FIELD_DESCRIPTION],
           Campaign::FIELD_IS_ACTIVE => $campaign[Campaign::FIELD_IS_ACTIVE],
           Campaign::FIELD_START_DATE => $campaign[Campaign::FIELD_START_DATE],
           Campaign::FIELD_END_DATE => $campaign[Campaign::FIELD_END_DATE],
        ]);
        $this->assertDatabaseHas(Campaign::TABLE, $campaign);
    }

    public function testCannotCreateCampaignWithInvalidData(): void
    {
        $response = $this->postJson('/api/campaigns', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            Campaign::FIELD_GROUP_ID,
            Campaign::FIELD_NAME,
        ]);
    }

    public function testCanListCampaigns(): void
    {
        $group = Group::factory()->create();
        $campaigns = Campaign::factory()->count(4)->create([Campaign::FIELD_GROUP_ID => $group->id]);
        $response = $this->getJson('/api/campaigns');

        $response->assertStatus(200);

        $responseData = $response->json('data');
        $this->assertCount(4, $responseData);
        $this->assertEquals(
            $campaigns->pluck('id')->sort()->values()->toArray(),
            collect($responseData)->pluck('id')->sort()->values()->toArray()
        );
    }

    public function testCanShowCampaign(): void
    {
        $group = Group::factory()->create();
        $campaign = Campaign::factory()->create([Campaign::FIELD_GROUP_ID => $group->id]);

        $response = $this->getJson("/api/campaigns/{$campaign->id}");

        $response->assertStatus(200);

        $responseData = $response->json('data');
        
        $this->assertEquals(
            $campaign->only(Campaign::FIELDS),
            collect($responseData)->only(Campaign::FIELDS)->toArray()
        );
    }

    public function testCannotShowNonExistentCampaign(): void
    {
        $response = $this->getJson('/api/campaigns/999999');

        $response->assertStatus(404);
    }

    public function testCanUpdateCampaign(): void
    {
        $group = Group::factory()->create();
        $campaign = Campaign::factory()->create([Campaign::FIELD_GROUP_ID => $group->id]);

        $updatedData = [
            Campaign::FIELD_GROUP_ID => $campaign->group_id,
            Campaign::FIELD_NAME => 'Updated Campaign Name',
            Campaign::FIELD_DESCRIPTION => 'Updated description',
            Campaign::FIELD_IS_ACTIVE => false,
            Campaign::FIELD_START_DATE => '2025-06-10',
            Campaign::FIELD_END_DATE => '2025-06-20',
        ];

        $response = $this->putJson("/api/campaigns/{$campaign->id}", $updatedData);

        $response->assertStatus(200);
        
        $responseData = $response->json('data');
        $this->assertEquals(
            collect($updatedData)->only(Campaign::FIELDS)->toArray(),
            collect($responseData)->only(Campaign::FIELDS)->toArray()
        );

        $this->assertDatabaseHas(Campaign::TABLE, array_merge(['id' => $campaign->id], $updatedData));
    }

    public function testCannotUpdateCampaignWithInvalidData(): void
    {
        $group = Group::factory()->create();
        $campaign = Campaign::factory()->create([Campaign::FIELD_GROUP_ID => $group->id]);

        $invalidData = [
            Campaign::FIELD_GROUP_ID => null,
            Campaign::FIELD_NAME => '',
        ];

        $response = $this->putJson("/api/campaigns/{$campaign->id}", $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            Campaign::FIELD_GROUP_ID,
            Campaign::FIELD_NAME,
        ]);
    }

    public function testCanDeleteCampaign(): void
    {
        $group = Group::factory()->create();
        $campaign = Campaign::factory()->create([Campaign::FIELD_GROUP_ID => $group->id]);

        $response = $this->deleteJson("/api/campaigns/{$campaign->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing(Campaign::TABLE, ['id' => $campaign->id]);
    }
}