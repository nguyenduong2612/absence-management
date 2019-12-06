<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'admin@gmail.com')->first();
        if (!$user) {
            User::create([
                'role' => 'admin',
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456')
            ]);
            User::create([
                'role' => 'user',
                'name' => 'Duong Hai Nguyen',
                'email' => 'nguyenduong@gmail.com',
                'password' => Hash::make('123456')
            ]);
            User::create([
                'role' => 'user',
                'name' => 'Phan Quoc Toan',
                'email' => 'quoctoan@gmail.com',
                'password' => Hash::make('123456')
            ]);
            User::create([
                'role' => 'user',
                'name' => 'Tran Manh Cong',
                'email' => 'manhcong@gmail.com',
                'password' => Hash::make('123456')
            ]);
            User::create([
                'role' => 'user',
                'name' => 'Nguyen Duc Anh',
                'email' => 'ducanh@gmail.com',
                'password' => Hash::make('123456')
            ]);
        }
    }
}
