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
            'password'       => '$2y$10$RezK2HYw9XP4AlJ2rQcaX.UZcgXF3Lus3YtDdCpwSRdfg/QTtfpYu',
            'remember_token' => null,
            'created_at'     => '2019-07-20 19:16:28',
            'updated_at'     => '2019-07-20 19:16:28',
            'deleted_at'     => null,
        ]];

        User::insert($users);
    }
}
