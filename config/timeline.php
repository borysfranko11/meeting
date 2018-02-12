<?php
//此处存放各种连接配置
return [
    'timeline' => [
        '101' => '创建会议',
        '102' => '会议审核',
        '103' => '发送询单',
        '104' => '确认场地',
        '105' => '下单',
        '106' => '上传水单',
        '107' => '结算',
        '108' => '取消',
    ],
    'timelinktest' => [
        '101' =>[
            [
                'path'=>'/Meeting/preview', //查看会议
                'linktype'=>'blank',
            ],
            [
                'path'=>'/Meeting/edit',//编辑会议
                'linktype'=>'blank',
            ]
        ],
        '101_102' =>[
            [
                'path'=>'/Meeting/preview', //查看会议
                'linktype'=>'blank',
            ],
            [
                'path'=>'/Meeting/edit',//编辑会议
                'linktype'=>'blank',
            ]
        ],
        '102' =>[
            [
                'path'=>'/Meeting/noticeAuthor',//提醒审核人
                'linktype'=>'ajax',
            ],
            [
                'path'=>'/Meeting/check',//会议审核
                'linktype'=>'blank',
            ]
        ],
        '103' =>[
                [
                    'path'=>'/Rfp/create',  //发送询单
                    'linktype'=>'blank',
                ],
                [
                    'path'=>'/Rfp/preview', //询单快照
                    'linktype'=>'blank',
                ],
        ],
        '103_108' =>[
                [
                    'path'=>'/Rfp/edit',    //编辑询单
                    'linktype'=>'blank',
                ],
                [
                    'path'=>'/Rfp/preview', //询单快照
                    'linktype'=>'blank',
                ],
            ],
        '103_103' =>[
                [
                    'path'=>'/Rfp/edit',    //编辑询单
                    'linktype'=>'blank',
                ],
                [
                    'path'=>'/Rfp/preview', //询单快照
                    'linktype'=>'blank',
                ],
            ],
        '103_104' =>[
                [
                    'path'=>'/Rfp/cancel',  //取消询单
                    'linktype'=>'ajax',
                ],
                [
                    'path'=>'/Rfp/preview', //询单快照
                    'linktype'=>'blank',
                ],
        ],
        '104' =>[
            [
                'path'=>'/Rfp/confirm/memo',   //确认场地
                'linktype'=>'blank',
            ],
        ],
        '105' =>[
            [
                'path'=>'/Order/preview',//订单详情
                'linktype'=>'blank',
            ]
        ],
        '106' =>[
            [
                'path'=>'/Memo/confirmMemo',//水单上传
                'linktype'=>'blank',
            ],
            [
                'path'=>'/Memo/preview',//查看水单
                'linktype'=>'blank',
            ]
        ],
        '107' =>[
            [
                'path'=>'',
                'linktype'=>'blank',
            ]
        ],

    ],
    'timelinkcreate' => [
        '101' =>[
            [
                'path'=>'/Meeting/preview', //查看会议
                'linktype'=>'blank',
            ],
            [
                'path'=>'/Meeting/edit',//编辑会议
                'linktype'=>'blank',
            ]
        ],
        '101_102' =>[
            [
                'path'=>'/Meeting/preview', //查看会议
                'linktype'=>'blank',
            ],
            [
                'path'=>'/Meeting/edit',//编辑会议
                'linktype'=>'blank',
            ]
        ],
        '102' =>[
            [
                'path'=>'/Meeting/noticeAuthor',//提醒审核人
                'linktype'=>'ajax',
            ]
        ],
        '103' =>[
            [
                'path'=>'/Rfp/create',  //发送询单
                'linktype'=>'blank',
            ],
            [
                'path'=>'/Rfp/preview', //询单快照
                'linktype'=>'blank',
            ],
        ],
        '103_108' =>[
            [
                'path'=>'/Rfp/edit',    //编辑询单
                'linktype'=>'blank',
            ],
            [
                'path'=>'/Rfp/preview', //询单快照
                'linktype'=>'blank',
            ],
        ],
        '103_103' =>[
            [
                'path'=>'/Rfp/edit',    //编辑询单
                'linktype'=>'blank',
            ],
            [
                'path'=>'/Rfp/preview', //询单快照
                'linktype'=>'blank',
            ],
        ],
        '103_104' =>[
            [
                'path'=>'/Rfp/cancel',  //取消询单
                'linktype'=>'ajax',
            ],
            [
                'path'=>'/Rfp/preview', //询单快照
                'linktype'=>'blank',
            ],
        ],
        '104' =>[
            [
                'path'=>'/Rfp/confirm/memo',   //确认场地
                'linktype'=>'blank',
            ],
        ],
        '105' =>[
            [
                'path'=>'/Order/preview',//订单详情
                'linktype'=>'blank',
            ]
        ],
        '106' =>[
            [
                'path'=>'/Memo/confirmMemo',//水单上传
                'linktype'=>'blank',
            ],
            [
                'path'=>'/Memo/preview',//查看水单
                'linktype'=>'blank',
            ]
        ],
        '107' =>[
            [
                'path'=>'',
                'linktype'=>'blank',
            ]
        ],

    ],
    'timelinkcheck' => [
        '102' =>[
            [
                'path'=>'/Meeting/check',//会议审核
                'linktype'=>'blank',
            ]
        ],
    ],
    'timelinkindex' => [
        '101' =>[
            [
                'path'=>'/Meeting/preview', //查看会议
                'linktype'=>'blank',
            ]
        ],
        '102' =>[
        ],
        '103' =>[
            [
                'path'=>'/Rfp/preview', //询单快照
                'linktype'=>'blank',
            ]
        ],
        '104' =>[
        ],
        '105' =>[
            [
                'path'=>'/Order/preview',//订单详情
                'linktype'=>'blank',
            ]
        ],
        '106' =>[
            [
                'path'=>'/Memo/preview',//查看水单
                'linktype'=>'blank',
            ]
        ],
        '107' =>[
            [
                'path'=>'',
                'linktype'=>'blank',
            ]
        ],

    ],
    'timelinkdeposit' => [
        '101' =>[
            [
                'path'=>'/Meeting/preview', //查看会议
                'linktype'=>'blank',
            ],
            [
                'path'=>'/Meeting/edit',//编辑会议
                'linktype'=>'blank',
            ]
        ],
        '101_102' =>[
            [
                'path'=>'/Meeting/preview', //查看会议
                'linktype'=>'blank',
            ],
            [
                'path'=>'/Meeting/edit',//编辑会议
                'linktype'=>'blank',
            ]
        ],
        '102' =>[
            [
                'path'=>'/Meeting/noticeAuthor',//提醒审核人
                'linktype'=>'ajax',
            ]
        ],
        '103' =>[
            [
                'path'=>'/Rfp/create',  //发送询单
                'linktype'=>'blank',
            ],
            [
                'path'=>'/Rfp/preview', //询单快照
                'linktype'=>'blank',
            ],
        ],
        '103_108' =>[
            [
                'path'=>'/Rfp/edit',    //编辑询单
                'linktype'=>'blank',
            ],
            [
                'path'=>'/Rfp/preview', //询单快照
                'linktype'=>'blank',
            ],
        ],
        '103_103' =>[
            [
                'path'=>'/Rfp/edit',    //编辑询单
                'linktype'=>'blank',
            ],
            [
                'path'=>'/Rfp/preview', //询单快照
                'linktype'=>'blank',
            ],
        ],
        '103_104' =>[
            [
                'path'=>'/Rfp/cancel',  //取消询单
                'linktype'=>'ajax',
            ],
            [
                'path'=>'/Rfp/preview', //询单快照
                'linktype'=>'blank',
            ],
        ],
        '104' =>[
            [
                'path'=>'/Rfp/confirm/memo',   //确认场地
                'linktype'=>'blank',
            ],
        ],
        '105' =>[
            [
                'path'=>'/Order/preview',//订单详情
                'linktype'=>'blank',
            ]
        ],
        '106' =>[
            [
                'path'=>'/Memo/preview',//查看水单
                'linktype'=>'blank',
            ]
        ],
        '107' =>[
            [
                'path'=>'',
                'linktype'=>'blank',
            ]
        ],
],
];
