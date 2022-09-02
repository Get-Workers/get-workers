<?php

namespace Database\Seeders;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create(['email' => 'test@test.com']);
        User::factory(10)->create();
        User::factory(10)->unverified()->create();
    }
}
