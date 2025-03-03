<?php

namespace Database\Seeders;

use App\Models\MailingCampaign;
use Illuminate\Database\Seeder;

class MailingCampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MailingCampaign::factory()->count(30)->create();
    }
}
