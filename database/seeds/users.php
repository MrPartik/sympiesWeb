<?php

use Illuminate\Database\Seeder;
use App\user;

class users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        user::truncate();

        $user = new user();
        $user->email ="loyolapat04@gmail.com";
        $user->name = "John Patrick Loyola";
        $user->password = bcrypt("pass");
        $user->AFF_ID=1;
        $user->role="admin";
        $user->save();

        $user = new user();
        $user->email ="islandrose@gmail.com";
        $user->name = "Cristina - Island Rose";
        $user->password = bcrypt("pass");
        $user->AFF_ID=2;
        $user->role="member";
        $user->save();
    }
}
