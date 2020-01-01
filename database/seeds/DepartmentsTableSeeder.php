<?php

use Illuminate\Database\Seeder;
use App\Department;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'name' => 'Phòng nhân sự'
        ]);
        Department::create([
            'name' => 'Phòng hành chính'
        ]);
        Department::create([
            'name' => 'Phòng phát triển'
        ]);
        Department::create([
            'name' => 'Phòng kinh doanh'
        ]);
    }
}
