<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
          	'name' => 'Admin',
          	'email' => 'admin@admin.com',
          	'password' => bcrypt('admin123'),
          	'level' => '1'
          	
      ]);
    }
}
