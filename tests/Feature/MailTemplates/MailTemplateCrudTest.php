<?php
declare(strict_types=1);

namespace Tests\Feature\MailTemplates;

use App\Models\MailTemplate;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailTemplateCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateMailTemplate(): void
    {
        $mailTemplate = MailTemplate::factory()->make()->toArray();

        $response = $this->postJson('/api/mail-templates', $mailTemplate);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            MailTemplate::FIELD_NAME => $mailTemplate[MailTemplate::FIELD_NAME],
            MailTemplate::FIELD_SUBJECT => $mailTemplate[MailTemplate::FIELD_SUBJECT],
            MailTemplate::FIELD_CONTENT => $mailTemplate[MailTemplate::FIELD_CONTENT],
            MailTemplate::FIELD_DESCRIPTION => $mailTemplate[MailTemplate::FIELD_DESCRIPTION],
            MailTemplate::FIELD_IS_ACTIVE => $mailTemplate[MailTemplate::FIELD_IS_ACTIVE],
        ]);
        $this->assertDatabaseHas(MailTemplate::TABLE, $mailTemplate);
    }

    public function testCannotCreateMailTemplateWithInvalidData(): void
    {
        $response = $this->postJson('/api/mail-templates', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            MailTemplate::FIELD_NAME,
            MailTemplate::FIELD_SUBJECT,
            MailTemplate::FIELD_CONTENT,
        ]);
    }

    public function testCanListMailTemplates(): void
    {
        $mailTemplates = MailTemplate::factory()->count(4)->create();

        $response = $this->getJson('/api/mail-templates');

        $response->assertStatus(200);

        $responseData = $response->json('data');
        $this->assertCount(4, $responseData);
        $this->assertEquals(
            $mailTemplates->pluck('id')->sort()->values()->toArray(),
            collect($responseData)->pluck('id')->sort()->values()->toArray()
        );
    }

    public function testCanShowMailTemplate(): void
    {
        $mailTemplate = MailTemplate::factory()->create(); 

        $response = $this->getJson("/api/mail-templates/{$mailTemplate->id}");

        $response->assertStatus(200);

        $responseData = $response->json('data');
        
        $this->assertEquals(
            $mailTemplate->only(MailTemplate::FIELDS),
            collect($responseData)->only(MailTemplate::FIELDS)->toArray()
        );
    }

    public function testCannotShowNonExistentMailTemplate(): void
    {
        $response = $this->getJson('/api/mail-templates/9999999');

        $response->assertStatus(404);
    }

    public function testCanUpdateMailTemplate(): void
    {
        $mailTemplate = MailTemplate::factory()->create();

        $updatedData = [
            MailTemplate::FIELD_NAME => 'Updated Template Name',
            MailTemplate::FIELD_SUBJECT => 'Updated Template Subject',
            MailTemplate::FIELD_CONTENT => '<p>Updated Content</p>',
            MailTemplate::FIELD_DESCRIPTION => 'Updated Template Description',
            MailTemplate::FIELD_IS_ACTIVE => true,
        ];
        

        $response = $this->putJson("/api/mail-templates/{$mailTemplate->id}", $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            MailTemplate::FIELD_NAME => $updatedData[MailTemplate::FIELD_NAME],
            MailTemplate::FIELD_SUBJECT => $updatedData[MailTemplate::FIELD_SUBJECT],
            MailTemplate::FIELD_CONTENT => $updatedData[MailTemplate::FIELD_CONTENT],
            MailTemplate::FIELD_DESCRIPTION => $updatedData[MailTemplate::FIELD_DESCRIPTION],
            MailTemplate::FIELD_IS_ACTIVE => $updatedData[MailTemplate::FIELD_IS_ACTIVE],
        ]);
        $this->assertDatabaseHas(MailTemplate::TABLE, array_merge(['id' => $mailTemplate->id], $updatedData));
    }

    public function testCannotUpdateGroupWithInvalidData(): void
    {
        $mailTemplate = MailTemplate::factory()->create();

        $invalidData = [
            MailTemplate::FIELD_NAME => null,
            MailTemplate::FIELD_SUBJECT => null,
            MailTemplate::FIELD_CONTENT => null,
        ];

        $response = $this->putJson("/api/mail-templates/{$mailTemplate->id}", $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            MailTemplate::FIELD_NAME,
            MailTemplate::FIELD_SUBJECT,
            MailTemplate::FIELD_CONTENT,
        ]);
    }

    public function testCanDeleteMailTemplate(): void
    {
        $mailTemplate = MailTemplate::factory()->create();

        $response = $this->deleteJson("/api/mail-templates/{$mailTemplate->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing(MailTemplate::TABLE, ['id' => $mailTemplate->id]);
    }
}