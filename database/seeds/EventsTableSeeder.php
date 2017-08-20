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
            $name = "event_$i";
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $name);
            $slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $text));

            $teams[] = factory(Event ::class)->make([
                'name' => $name,
                'admin_id' => $admins->random()->id,
                'slug' => $slug
            ])->toArray();
        }

        Event::insert($teams);
    }
}

