<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Group;
use App\Models\MailingCampaign;
use App\Models\MailTemplate;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET CONSTRAINTS ALL DEFERRED;');

        foreach ([
            Group::TABLE,
            Campaign::TABLE,
            Contact::TABLE,
            MailTemplate::TABLE,
            MailingCampaign::TABLE,
            Task::TABLE,
        ] as $table) {
            DB::table($table)->truncate();
        }

        $this->call([
            GroupSeeder::class,
            CampaignSeeder::class,
            ContactSeeder::class,
            MailTemplateSeeder::class,
            MailingCampaignSeeder::class,
            TaskSeeder::class,
        ]);

    }
}
