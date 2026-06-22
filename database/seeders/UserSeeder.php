<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;
use App\Enums\Role;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $code = [
            Role::ADMIN->value => 'admin',
            Role::STAFF->value => 'stahh',
            Role::CUSTOMER->value => 'customer',
        ];

        $user = [
            'id' => 1,
            'name' => 'Guest User',
            'email' => 'guest@example.com',
            'password' => '12345678'
        ];

        DB::table('users')->insert($user);
        // foreach ($code as $item) {
        //     DB::
        // }
    }
}
