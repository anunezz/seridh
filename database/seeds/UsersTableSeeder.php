<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        [
            'id'                => 1,
            'username'          =>'igomez',
            'cat_profile_id'    => 1,
            'name'              => 'ivan',
            'firstName'         => 'perdomo',
            'secondName'        => 'gomez',
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]
        ]);
    }
}
