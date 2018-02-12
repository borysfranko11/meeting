<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class JoinUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('join_users')->insert([
            'name' => '测试数据',
            'rfp_id'=> '1',
            'sex'=> 1,
            'phone'=> '18845678888',
            'city'=> '北京',
            'company'=> '公司',
            'duty'=> '职位',
            'id_card'=> '254878599874558965',
            'email'=> '1111111@163.com',
            'room_type'=> '大床房',
            'create_user'=> '1',
            'create_time' => time(),
            'status'=>'1',
        ]);
    }
}
