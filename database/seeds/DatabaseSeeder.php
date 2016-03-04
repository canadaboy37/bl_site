<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('DealerTableSeeder');
        $this->command->info('Dealer table seeded');
        $this->call('userTableSeeder');
        $this->command->info('User table seeded');

        Model::reguard();
    }
}
