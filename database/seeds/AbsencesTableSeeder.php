<?php

use App\Absence;
use Illuminate\Database\Seeder;

class AbsencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Absence::create([
            'user_id' => '3',
            'reason' => 'Bị ốm',
            'start_at' => '2019-12-05 12:00:00',
            'end_at' => '2019-12-06 18:00:00',
            'status' => 'accepted'
        ]);
        Absence::create([
            'user_id' => '3',
            'reason' => 'Vẫn bị ốm chưa khỏi',
            'start_at' => '2019-12-07 08:00:00',
            'end_at' => '2019-12-13 08:00:00',
            'status' => 'rejected'
        ]);
        Absence::create([
            'user_id' => '2',
            'reason' => 'Nghỉ 1 ngày về thăm nhà',
            'start_at' => '2019-12-10 08:00:00',
            'end_at' => '2019-12-11 08:00:00',
            'status' => 'accepted'
        ]);
        Absence::create([
            'user_id' => '5',
            'reason' => 'Đi nộp hồ sơ công tác',
            'start_at' => '2019-12-12 08:00:00',
            'end_at' => '2019-12-12 12:00:00',
            'status' => 'pending'
        ]);
        Absence::create([
            'user_id' => '4',
            'reason' => 'Nghỉ đi công tác',
            'start_at' => '2019-12-15 08:00:00',
            'end_at' => '2019-12-16 08:00:00',
            'status' => 'pending'
        ]);
        Absence::create([
            'user_id' => '2',
            'reason' => 'Nghỉ 1 ngày về quê',
            'start_at' => '2019-12-26 08:00:00',
            'end_at' => '2019-12-27 08:00:00',
            'status' => 'accepted'
        ]);
        Absence::create([
            'user_id' => '5',
            'reason' => 'Nghỉ đi du lịch với gia đình',
            'start_at' => '2019-12-20 08:00:00',
            'end_at' => '2019-12-27 08:00:00',
            'status' => 'rejected'
        ]);
        Absence::create([
            'user_id' => '4',
            'reason' => 'Nghỉ chăm con bị ốm',
            'start_at' => '2019-12-31 08:00:00',
            'end_at' => '2019-12-31 18:00:00',
            'status' => 'pending'
        ]);
    }
}
