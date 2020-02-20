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
                'username'          =>'hpiedras',
                'cat_profile_id'    => 1,
                'name'              => 'Homero',
                'firstName'         => 'Piedras',
                'secondName'        => 'Rodríguez',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'                => 2,
                'username'          =>'pdominguez',
                'cat_profile_id'    => 1,
                'name'              => 'Pedro',
                'firstName'         => 'Domínguez',
                'secondName'        => 'Díaz',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'                => 3,
                'username'          =>'pnudddh01',
                'cat_profile_id'    => 1,
                'name'              => 'Daniela Leticia',
                'firstName'         => 'Mondragón',
                'secondName'        => 'Pineda',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'                => 4,
                'username'          =>'pnudddh02',
                'cat_profile_id'    => 1,
                'name'              => 'Adalberto',
                'firstName'         => 'Castañeda',
                'secondName'        => 'Vidal',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'                => 5,
                'username'          =>'pnudddh03',
                'cat_profile_id'    => 1,
                'name'              => 'Iván Emmanuel',
                'firstName'         => 'Morales',
                'secondName'        => 'Mendoza',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'                => 6,
                'username'          =>'cballinas',
                'cat_profile_id'    => 1,
                'name'              => 'Cristopher',
                'firstName'         => 'Ballinas',
                'secondName'        => 'Valdés',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
        ]);

    }
}
