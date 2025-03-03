<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET CONSTRAINTS ALL DEFERRED;');

        foreach ([
            'groups',
            'campaigns',
            'contacts',
            'mail_templates',
            'mailing_campaigns',
            'tasks',
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
