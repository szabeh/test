<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [[
            'id'             => 1,
            'name'           => 'Admin',
            'email'          => 'admin@admin.com',
            'password'       => '$2y$10$LAFJpa7g5CMsdLzi44klJOxDekJdwWy3vtEg2lZjqPeJrgEQvwu0u',
            'remember_token' => null,
            'created_at'     => '2019-07-20 19:31:48',
            'updated_at'     => '2019-07-20 19:31:48',
            'deleted_at'     => null,
        ]];

        User::insert($users);
    }
}
