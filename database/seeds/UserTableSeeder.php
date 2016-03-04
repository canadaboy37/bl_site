<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use App\Models\Dealer;
use App\User;

class userTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();

        $dealerId = Dealer::first()->id;

        $user = new user;
        $user->dealer_id = $dealerId;
        $user->name = 'Angela';
        $user->email = "angela@feynmangroup.com";
        $user->password = 'password';
        $user->is_salesperson = false;
        $user->save();

        $user = new user;
        $user->dealer_id = $dealerId + 1;
        $user->name = 'John Smith';
        $user->email = "jsmith@test.com";
        $user->password = 'password';
        $user->is_salesperson = false;
        $user->save();
    }

}
