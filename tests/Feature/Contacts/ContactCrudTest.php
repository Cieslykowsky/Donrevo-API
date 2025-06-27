<?php
declare(strict_types=1);

namespace Tests\Feature\Contacts;

use Tests\TestCase;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateContact(): void
    {
        $contact = Contact::factory()->make()->toArray();

        $response = $this->postJson('/api/contacts', $contact);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            Contact::FIELD_FIRST_NAME => $contact[Contact::FIELD_FIRST_NAME],
            Contact::FIELD_LAST_NAME => $contact[Contact::FIELD_LAST_NAME],
        ]);
        $this->assertDatabaseHas(Contact::TABLE, $contact);
    }

    public function testCannotCreateContactWithInvalidData(): void
    {
        $response = $this->postJson('/api/contacts', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    public function testCanListContacts(): void
    {
        $contacts = Contact::factory()->count(4)->create();
        $response = $this->getJson('/api/contacts');

        $response->assertStatus(200);

        $responseData = $response->json('data');
        $this->assertCount(4, $responseData);
        $this->assertEquals(
            $contacts->pluck('id')->sort()->values()->toArray(),
            collect($responseData)->pluck('id')->sort()->values()->toArray()
        );
    }

    public function testCanShowContact(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->getJson("/api/contacts/{$contact->id}");

        $response->assertStatus(200);
        
        $responseData = $response->json('data');

        $this->assertEquals(
            $contact->only(Contact::FIELDS),
            collect($responseData)->only(Contact::FIELDS)->toArray()
        );
    }

    public function testCannotShowNonExistentContact(): void
    {
        $response = $this->getJson('/api/contacts/9999999');

        $response->assertStatus(404);
    }

    public function testCanUpdateContact(): void
    {
        $contact = Contact::factory()->create();

        $updatedData = [
            Contact::FIELD_FIRST_NAME => 'Updated First Name',
            Contact::FIELD_LAST_NAME => 'Updated Last Name',
            Contact::FIELD_EMAIL => 'updated.email@example.com',
            Contact::FIELD_PHONE => null,
            Contact::FIELD_STREET => null,
            Contact::FIELD_HOUSE_NUMBER => '123',
            Contact::FIELD_POSTAL_CODE => '12-345',
            Contact::FIELD_CITY => null,
            Contact::FIELD_COUNTRY => null,
            Contact::FIELD_IS_ACTIVE => true,
            Contact::FIELD_NOTES => null,
        ];

        $response = $this->putJson("/api/contacts/{$contact->id}", $updatedData);

        $response->assertStatus(200);

        $responseData = $response->json('data');
        $this->assertEquals(
            collect($updatedData)->only(Contact::FIELDS)->toArray(),
            collect($responseData)->only(Contact::FIELDS)->toArray()
        );

        $this->assertDatabaseHas(Contact::TABLE, array_merge(['id' => $contact->id], $updatedData));
    }

    public function testCannotUpdateCampaignWithInvalidData(): void
    {
        $contact = Contact::factory()->create();

        $invalidData = [
            Contact::FIELD_EMAIL => null,
        ];

        $response = $this->putJson("/api/contacts/{$contact->id}", $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            Contact::FIELD_EMAIL,
        ]);
    }

    public function testCanDeleteContact(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->deleteJson("/api/contacts/{$contact->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing(Contact::TABLE, ['id' => $contact->id]);
    }
}