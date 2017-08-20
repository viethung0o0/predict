<?php

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Admin;


class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = Admin::all(['id']);
        $teams = [];

        for ($i = 1; $i <= 10; $i++) {
            $teams[] = factory(Team ::class)->make([
                'name' => "team_$i",
                'admin_id' => $admins->random()->id
            ])->toArray();
        }

        Team::insert($teams);
    }
}

