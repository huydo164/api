<?php

namespace Modules\Event\Seeders;

use Illuminate\Database\Seeder;
use Modules\Event\Models\Event;
use Faker\Generator as Faker;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i <= 30; $i++) {
            Event::updateOrCreate(
                [
                    'id' => $i
                ],
                [
                    'start_date' => rand(1639706639, 1646273039),
                    'category_id' => 2,
                    'user_id' => 1,
                    'problem' => $faker->jobTitle,
                    'solution' => $faker->paragraph,
                    'risk' => $faker->paragraph,
                    'status' => Event::EVENT_STATUS_PROCESSING,
                ]
            );
        }
    }
}
