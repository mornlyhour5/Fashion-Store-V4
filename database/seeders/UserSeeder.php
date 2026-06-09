<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\Role;

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
        ];

        DB::table('users')->insert($user);
        foreach ($code as $item) {
            DB::
        }
    }
}
