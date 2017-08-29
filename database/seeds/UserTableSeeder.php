<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
               'name' => 'admin',
               'password' => 'abc123@abc',
               'email' => 'admin@gmail.com'
            ],
            [
               'name' => 'nam',
               'password' => '123456',
               'email' => 'nam@gmail.com'
            ],
        ]);
    }
}
