<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = [
            'teams',
            'users',
            'events',
            'admins',
        ];

        $this->command->info('Truncating existing tables');

        foreach ($tables as $table) {
            DB::statement('TRUNCATE TABLE ' . $table . ' RESTART IDENTITY CASCADE;');
        }
        $this->command->info('Creating seeder data');

        Model::unguard();

        $this->call(AdminsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
        $this->call(EventsTableSeeder::class);

        Model::reguard();
    }
}

