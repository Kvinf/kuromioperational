<?php

namespace Database\Seeders;

use App\Models\MsUser;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $id = Str::uuid();

        $hashed = Hash::make('test123');

        $insertItem = ([
            'id' => $id,
            'email' => 'kurimi123',
            'password' => $hashed,
            'verified' => 1,
            'username' => 'kurimi'
        ]);

        MsUser::create($insertItem);

    }
}
