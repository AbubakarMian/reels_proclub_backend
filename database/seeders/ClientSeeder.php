<?php

namespace Database\Seeders;

use App\Models\Client ;
use Illuminate\Database\Seeder;


class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::firstOrCreate(
            ['client_id' => 'reelspro-app-mobile'],
            ['client_secret' => 'cmVlbHNwcm8tYXBwLW1vYmlsZTogY21WbGJITndjbTh0WVhCd0xXMXZZbWxzWlE9PQ==']
        );
    }
}
