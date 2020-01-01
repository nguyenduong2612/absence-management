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
                'department_id' => '1',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456')
            ]);
            User::create([
                'role' => 'user',
                'name' => 'Duong Hai Nguyen',
                'department_id' => '2',
                'email' => 'nguyenduong@gmail.com',
                'password' => Hash::make('123456')
            ]);
            User::create([
                'role' => 'user',
                'name' => 'Phan Quoc Toan',
                'department_id' => '3',
                'email' => 'quoctoan@gmail.com',
                'password' => Hash::make('123456')
            ]);
            User::create([
                'role' => 'user',
                'name' => 'Tran Manh Cong',
                'department_id' => '4',
                'email' => 'manhcong@gmail.com',
                'password' => Hash::make('123456')
            ]);
            User::create([
                'role' => 'user',
                'name' => 'Nguyen Duc Anh',
                'department_id' => '3',
                'email' => 'ducanh@gmail.com',
                'password' => Hash::make('123456')
            ]);
        }
    }
}
