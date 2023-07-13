<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      User::firstOrCreate(
            ['email'    => 'admin@mail.com'],
            [
                'name'   => 'admin',
                'role_id'   => '1',
                'password'   =>  Hash::make('abc123'),
                'phone_no'   =>  '1234',
            ]
        );
    }
}
