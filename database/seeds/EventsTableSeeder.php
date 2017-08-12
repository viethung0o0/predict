<?php

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Admin;


class EventsTableSeeder extends Seeder
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
            $teams[] = factory(Event ::class)->make([
                'name' => "event_$i",
                'admin_id' => $admins->random()->id
            ])->toArray();
        }

        Event::insert($teams);
    }
}
