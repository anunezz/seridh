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
            'username'          =>'jrojo',
            'cat_profile_id'    => 1,
            'name'              => 'Manuel',
            'firstName'         => 'Rojo',
            'secondName'        => 'Marquez',
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]
        ]);
    }
}
