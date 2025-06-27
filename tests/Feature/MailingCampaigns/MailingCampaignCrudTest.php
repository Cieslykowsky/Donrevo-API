<?php
declare(strict_types=1);

namespace Tests\Feature\MailingCampaigns;

use App\Models\Campaign;
use App\Models\Group;
use Tests\TestCase;
use App\Models\MailingCampaign;
use App\Models\MailTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailingCampaignCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function createRelatedRecordsForMailingCampaign(): array
    {
        $group = Group::factory()->create();
        $campaign = Campaign::factory()->create([Campaign::FIELD_GROUP_ID => $group->id]);
        $mailTemplate = MailTemplate::factory()->create();

        return [
            MailingCampaign::FIELD_CAMPAIGN_ID => $campaign->id,
            MailingCampaign::FIELD_MAIL_TEMPLATE_ID => $mailTemplate->id,
        ];
    }

    public function testCanCreateMailingCampaign(): void
    {
        $relatedRecords = $this->createRelatedRecordsForMailingCampaign();
        
        $mailingCampaign = MailingCampaign::factory()->make([
            MailingCampaign::FIELD_CAMPAIGN_ID => $relatedRecords[MailingCampaign::FIELD_CAMPAIGN_ID],
            MailingCampaign::FIELD_MAIL_TEMPLATE_ID => $relatedRecords[MailingCampaign::FIELD_MAIL_TEMPLATE_ID],
        ])->toArray(); 
        
        $response = $this->postJson('/api/mailing-campaigns', $mailingCampaign);
        
        $response->assertStatus(201);
        $response->assertJsonFragment([
            MailingCampaign::FIELD_CAMPAIGN_ID => $mailingCampaign[MailingCampaign::FIELD_CAMPAIGN_ID],
            MailingCampaign::FIELD_MAIL_TEMPLATE_ID => $mailingCampaign[MailingCampaign::FIELD_MAIL_TEMPLATE_ID],
            MailingCampaign::FIELD_NAME => $mailingCampaign[MailingCampaign::FIELD_NAME],
            MailingCampaign::FIELD_SUBJECT => $mailingCampaign[MailingCampaign::FIELD_SUBJECT],
            MailingCampaign::FIELD_CONTENT => $mailingCampaign[MailingCampaign::FIELD_CONTENT],
            MailingCampaign::FIELD_IS_ACTIVE => $mailingCampaign[MailingCampaign::FIELD_IS_ACTIVE],
            MailingCampaign::FIELD_SCHEDULED_AT => $mailingCampaign[MailingCampaign::FIELD_SCHEDULED_AT],
            MailingCampaign::FIELD_SENT_AT => $mailingCampaign[MailingCampaign::FIELD_SENT_AT],
        ]);
        $this->assertDatabaseHas(MailingCampaign::TABLE, $mailingCampaign);
    }

    public function testCannotCreateMailingCampaignWithInvalidData(): void
    {
        $response = $this->postJson('/api/mailing-campaigns', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            MailingCampaign::FIELD_CAMPAIGN_ID,
            MailingCampaign::FIELD_NAME
        ]);
    }

    public function testCanListMailingCampaigns(): void
    {     
        $relatedRecords = $this->createRelatedRecordsForMailingCampaign();

        $mailingCampaigns = MailingCampaign::factory()->count(4)->create([
            MailingCampaign::FIELD_CAMPAIGN_ID => $relatedRecords[MailingCampaign::FIELD_CAMPAIGN_ID],
            MailingCampaign::FIELD_MAIL_TEMPLATE_ID => $relatedRecords[MailingCampaign::FIELD_MAIL_TEMPLATE_ID],
        ]);

        $response = $this->getJson('/api/mailing-campaigns');

        $response->assertStatus(200);
        
        $responseData = $response->json('data');
        $this->assertCount(4, $responseData);
        $this->assertEquals(
            $mailingCampaigns->pluck('id')->sort()->values()->toArray(),
            collect($responseData)->pluck('id')->sort()->values()->toArray()
        );
    }

    public function testCanShowMailingCampaign(): void
    {
        $relatedRecords = $this->createRelatedRecordsForMailingCampaign();
        
        $mailingCampaign = MailingCampaign::factory()->create([
            MailingCampaign::FIELD_CAMPAIGN_ID => $relatedRecords[MailingCampaign::FIELD_CAMPAIGN_ID],
            MailingCampaign::FIELD_MAIL_TEMPLATE_ID => $relatedRecords[MailingCampaign::FIELD_MAIL_TEMPLATE_ID],
        ]); 
        
        $response = $this->getJson("/api/mailing-campaigns/{$mailingCampaign->id}");

        $response->assertStatus(200);

        $responseData = $response->json('data');
        
        $this->assertEquals(
            $mailingCampaign->only(MailingCampaign::FIELDS),
            collect($responseData)->only(MailingCampaign::FIELDS)->toArray()
        );
    }

    public function testCannotShowNonExistentMailingCampaign(): void
    {
        $response = $this->getJson('/api/mailing-campaigns/9999999');

        $response->assertStatus(404);
    }

    public function testCanUpdateMailingCampaign(): void
    {
        $relatedRecords = $this->createRelatedRecordsForMailingCampaign();
        
        $mailingCampaign = MailingCampaign::factory()->create([
            MailingCampaign::FIELD_CAMPAIGN_ID => $relatedRecords[MailingCampaign::FIELD_CAMPAIGN_ID],
            MailingCampaign::FIELD_MAIL_TEMPLATE_ID => $relatedRecords[MailingCampaign::FIELD_MAIL_TEMPLATE_ID],
        ]); 

        $updatedData = [
            MailingCampaign::FIELD_CAMPAIGN_ID => $relatedRecords[MailingCampaign::FIELD_CAMPAIGN_ID],
            MailingCampaign::FIELD_MAIL_TEMPLATE_ID => $relatedRecords[MailingCampaign::FIELD_MAIL_TEMPLATE_ID],
            MailingCampaign::FIELD_NAME => 'Updated Campaign Name',
            MailingCampaign::FIELD_SUBJECT => 'Updated Campaign Subject',
            MailingCampaign::FIELD_CONTENT => 'Updated Campaign Content',
            MailingCampaign::FIELD_IS_ACTIVE => false,
            MailingCampaign::FIELD_SCHEDULED_AT => '2025-06-22 12:00:00',
            MailingCampaign::FIELD_SENT_AT => '2025-06-23 12:00:00',
        ];

        $response = $this->putJson("/api/mailing-campaigns/{$mailingCampaign->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            MailingCampaign::FIELD_CAMPAIGN_ID => $updatedData[MailingCampaign::FIELD_CAMPAIGN_ID],
            MailingCampaign::FIELD_MAIL_TEMPLATE_ID => $updatedData[MailingCampaign::FIELD_MAIL_TEMPLATE_ID],
            MailingCampaign::FIELD_NAME => $updatedData[MailingCampaign::FIELD_NAME],
            MailingCampaign::FIELD_SUBJECT => $updatedData[MailingCampaign::FIELD_SUBJECT],
            MailingCampaign::FIELD_CONTENT => $updatedData[MailingCampaign::FIELD_CONTENT],
            MailingCampaign::FIELD_IS_ACTIVE => $updatedData[MailingCampaign::FIELD_IS_ACTIVE],
            MailingCampaign::FIELD_SCHEDULED_AT => $updatedData[MailingCampaign::FIELD_SCHEDULED_AT],
            MailingCampaign::FIELD_SENT_AT => $updatedData[MailingCampaign::FIELD_SENT_AT],
        ]);
        $this->assertDatabaseHas(MailingCampaign::TABLE, array_merge(['id' => $mailingCampaign->id], $updatedData));
    }

    public function testCannotUpdateMailingCampaignWithInvalidData(): void
    {
        $relatedRecords = $this->createRelatedRecordsForMailingCampaign();
        
        $mailingCampaign = MailingCampaign::factory()->create([
            MailingCampaign::FIELD_CAMPAIGN_ID => $relatedRecords[MailingCampaign::FIELD_CAMPAIGN_ID],
            MailingCampaign::FIELD_MAIL_TEMPLATE_ID => $relatedRecords[MailingCampaign::FIELD_MAIL_TEMPLATE_ID],
        ]); 


        $invalidData = [
            MailingCampaign::FIELD_CAMPAIGN_ID => null,
            MailingCampaign::FIELD_NAME => null,
        ];

        $response = $this->putJson("/api/mailing-campaigns/{$mailingCampaign->id}", $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            MailingCampaign::FIELD_CAMPAIGN_ID,
            MailingCampaign::FIELD_NAME,
        ]);
    }

    public function testCanDeleteMailingCampaign(): void
    {
        $relatedRecords = $this->createRelatedRecordsForMailingCampaign();
        
        $mailingCampaign = MailingCampaign::factory()->create([
            MailingCampaign::FIELD_CAMPAIGN_ID => $relatedRecords[MailingCampaign::FIELD_CAMPAIGN_ID],
            MailingCampaign::FIELD_MAIL_TEMPLATE_ID => $relatedRecords[MailingCampaign::FIELD_MAIL_TEMPLATE_ID],
        ]); 

        $response = $this->deleteJson("/api/mailing-campaigns/{$mailingCampaign->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing(MailingCampaign::TABLE, ['id' => $mailingCampaign->id]);
    }

}