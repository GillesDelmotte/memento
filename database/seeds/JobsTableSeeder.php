<?php

use Illuminate\Database\Seeder;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \memento\Job::create([
            'name' => 'Kiné'
        ]);
        \memento\Job::create([
            'name' => 'Ostéo'
        ]);
        \memento\Job::create([
            'name' => 'Coiffeur'
        ]);
        \memento\Job::create([
            'name' => 'Médecin'
        ]);
    }
}
