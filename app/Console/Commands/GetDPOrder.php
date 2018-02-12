<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libs\EveClient;
use App\Libs\Http;
use Illuminate\Support\Facades\DB;
use Log;


class GetDPOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dporder:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'dianping order info';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this -> Http           = new Http();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //获取近5分钟的订单
        $fromTime = time()-5*60;
        $toTime = time();
        $rs = $this->businessOrderIdsQuery($fromTime,$toTime);
        if(isset($rs['code']) && $rs['code'] == '2770'){//调用成功状态
            $orderIds =  json_decode($rs['content'],true);
            if(!empty($orderIds)){
                foreach ($orderIds as $key=>$val){
                    $orderInfo = $this->businessOrderQuery($val);
                    if(!empty($orderInfo) && isset($orderInfo['thirdOrderId'])){
                        $data['rfp_id'] = $orderInfo['thirdOrderId'];
                        $data['order_id'] = $orderInfo['orderId'];
                        $data['orderCreateTime'] = $orderInfo['orderUpdateTime'];
                        DB::table('rfp_dporder')->insert($data);
                    }else{
                        $message = '['.date('Y-m-d H:i:s',$fromTime).'-'.date('Y-m-d H:i:s',$toTime).']'.json_encode($orderInfo);
                        Log::alert( $message );
                    }
                }
            }else{
                $message = '['.date('Y-m-d H:i:s',$fromTime).'-'.date('Y-m-d H:i:s',$toTime).']'.$rs['content'];
                Log::alert( $message );
            }
        }else{
            $message = '['.date('Y-m-d H:i:s',$fromTime).'-'.date('Y-m-d H:i:s',$toTime).']'.json_encode($rs);
            Log::alert( $message );
        }
    }

    public function businessOrderIdsQuery($fromTime,$toTime){
        $timer = time();
        $content = [
            "entId" => config('system.staff_info.entId'),
            "fromTime" => $fromTime,//开始时间
            "toTime" => $toTime,//结束时间
            "sign" => config('system.staff_info.sign'),
            "ts" => $timer
        ];
        $content = json_encode( $content );
        $token = config('system.staff_info.token');
        $version = config('system.staff_info.version');
        $param = [
            'content' => $content,
            'token' => $token,
            'version' => $version
        ];
        $url = 'https://b.dianping.com/openapi/businessOrderIdsQuery?token='.$token.'&content='.$content.'&version='.$version;

        $request = $this -> Http -> httppost( $url, $param );
        return json_decode($request,true);
    }
    public function businessOrderQuery($orderId){
        $timer = time();
        $content = [
            "entId" => config('system.staff_info.entId'),
            "orderId" => $orderId,
            "sign" => config('system.staff_info.sign'),
            "ts" => $timer
        ];

        $content = json_encode( $content );
        $token = config('system.staff_info.token');
        $version = config('system.staff_info.version');

        $param = [
            'content' => $content,
            'token' => $token,
            'version' => $version
        ];
        $url = 'https://b.dianping.com/openapi/businessOrderQuery?token='.$token.'&content='.$content.'&version='.$version;

        $request = $this -> Http -> httppost( $url, $param );
        $rs = json_decode($request,true);
        $orderInfo = array();
        if(isset($rs['code']) && $rs['code'] == '2770'){//调用成功状态
            $orderInfo =  json_decode($rs['content'],true);
            $orderInfo['bookingTime'] = date('Y-m-d H:i:s',$orderInfo['bookingTime']);
            $orderInfo['orderUpdateTime'] = date('Y-m-d H:i:s',$orderInfo['orderUpdateTime']);
            $orderInfo['gender'] = config('system.staff_gender.'.$orderInfo['gender']);
            $orderInfo['platform'] = config('system.staff_platform.'.$orderInfo['platform']);
            $orderInfo['position'] = config('system.staff_position.'.$orderInfo['position']);
            $orderInfo['payStatus'] = config('system.staff_payStatus.'.$orderInfo['payStatus']);
            $orderInfo['status'] = config('system.staff_status.'.$orderInfo['status']);
        }
        return $orderInfo;
    }

}
