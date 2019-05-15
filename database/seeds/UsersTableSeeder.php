<?php

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
        \memento\User::create([
            'name' => 'Gilles Delmotte',
            'email' => 'gilles.delmotte@outlook.be',
            'job_id' => 1,
            'address' => 'Rue Fraischamps 154, 4030 grivegnée',
            'gsm' => '0497 36 85 95',
            'schedule' => true,
            'private' => true,
            'password' => Hash::make('azerty'),
            'api_token' => str_random(60)
        ]);
        \memento\User::create([
            'name' => 'Didier Delmotte',
            'email' => 'didier.delmotte@outlook.be',
            'job_id' => 2,
            'address' => 'Rue Fraischamps 154, 4030 grivegnée',
            'gsm' => '0497 36 85 95',
            'schedule' => true,
            'private' => true,
            'password' => Hash::make('azerty'),
            'api_token' => str_random(60)
        ]);
        \memento\User::create([
            'name' => 'Simon Delmotte',
            'email' => 'simon.delmotte@outlook.be',
            'job_id' => 3,
            'address' => 'Rue Fraischamps 154, 4030 grivegnée',
            'gsm' => '0497 36 85 95',
            'schedule' => true,
            'private' => true,
            'password' => Hash::make('azerty'),
            'api_token' => str_random(60)
        ]);
    }
}
