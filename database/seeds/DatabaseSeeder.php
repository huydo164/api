<?php

use Illuminate\Database\Seeder;
use Modules\Role\Seeders\RoleSeeder;
use Modules\User\Seeders\UserSeeder;
use Modules\Event\Seeders\EventSeeder;
use Modules\Notification\Seeders\NotificationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            EventSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
