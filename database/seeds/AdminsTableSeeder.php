<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [];

        for ($i = 1; $i <= 10; $i++) {
            $admins[] = factory(Admin::class)->make([
                'email' => "admin_$i@example.com"
            ])->toArray();
        }

        Admin::insert($admins);
    }
}

