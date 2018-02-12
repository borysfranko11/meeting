<?php
//此处存放各种连接配置
return [
    'role'=>[
        '1'=>[
            'role_id' => '1',
            'name' => '媒体',
            'hotel' => [
                '1' => [
                    'id' => 1,
                    'name' => '北京国贸大酒店',
                    'room_type' => '大床间',
                    'max_perple'=>'93',
                    'start_date'=>'2018-04-17',
                    'end_date'=>'2018-04-18',
                ]
            ],
        ],
        '2'=>[
            'role_id' => '1',
            'name' => '经销商',
            'hotel' => [
                '2' => [
                    'id' => 2,
                    'name' => '北京中国大饭店',
                    'room_type' => '标准间',
                    'max_perple'=>'160',
                    'start_date'=>'2018-04-18',
                    'end_date'=>'2018-04-19',
                ],
                '3' => [
                    'id' => 3,
                    'name' => '北京新国贸饭店',
                    'room_type' => '标准间',
                    'max_perple'=>'282',
                    'start_date'=>'2018-04-18',
                    'end_date'=>'2018-04-19',
                ],
            ],
        ],
        '3'=>[
            'role_id' => '1',
            'name' => '员工',
            'hotel' => [
                '2' => [
                    'id' => 2,
                    'name' => '北京中国大饭店',
                    'room_type' => '大床间',
                    'max_perple'=>'20',
                    'start_date'=>'2018-04-14',
                    'end_date'=>'2018-04-19',
                ],
                '4' => [
                    'id' => 4,
                    'name' => '北京京伦饭店',
                    'room_type' => '标准间',
                    'max_perple'=>'360',
                    'start_date'=>'2018-04-16',
                    'end_date'=>'2018-04-19',
                ],
                '5' => [
                    'id' => 5,
                    'name' => '北京建国饭店',
                    'room_type' => '标准间',
                    'max_perple'=>'66',
                    'start_date'=>'2018-04-16',
                    'end_date'=>'2018-04-17',
                ],
            ],
        ],
    ],

];
