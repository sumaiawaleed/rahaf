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
        $user = \App\User::create([
            'name' => 'Sumaia',
            'email' => 'super_admin@app.com',
            'password' => bcrypt("123456")
        ]);

    }
}
