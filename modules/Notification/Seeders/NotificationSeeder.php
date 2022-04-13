<?php

namespace Modules\Notification\Seeders;

use Illuminate\Database\Seeder;
use Modules\Notification\Models\Notification;
use Faker\Generator as Faker;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i <= 20; $i++) {
            Notification::updateOrCreate(
                [
                    'id' => $i
                ],
                [
                    'user_id' => 1,
                    'title' => $faker->jobTitle,
                    'content' => $faker->paragraph,
                ]
            );
        }
    }
}
