<?php

use Illuminate\Database\Seeder;

class NotificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \memento\Notification::create([
            'user_id' => '1',
            'delay' => '2',
            'message' => 'Bonjour, vous avez rendez vous avec Gilles Delmotte le [date] à [heure]',
        ]);
        \memento\Notification::create([
            'user_id' => '2',
            'delay' => '1',
            'message' => 'Bonjour, vous avez rendez vous avec Didier Delmotte le [date] à [heure]',
        ]);
        \memento\Notification::create([
            'user_id' => '3',
            'delay' => '3',
            'message' => 'Bonjour, vous avez rendez vous avec Simon Delmotte le [date] à [heure]',
        ]);
    }
}
