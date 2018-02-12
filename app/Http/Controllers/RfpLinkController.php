<?php
/**
 * des: 询单逻辑处理控制器
 */
namespace App\Http\Controllers;

use App\Models\RfpLink;
use App\Models\Servers;
use App\Models\ServersStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Libs\EveClient;

class RfpLinkController extends Controller
{
    private $_RfpLink;
    private $_Servers;
    private $_ServersStaff;
    public $return = ['Success' => true,'Msg'=> '', 'Data' => ''];

    public function __construct()
    {
        parent::__construct();

        $this -> _RfpLink   = new RfpLink();
        $this -> _Servers   = new Servers();
        $this -> _ServersStaff   = new ServersStaff();
        $this ->EveClient   = new EveClient();
    }

    public function index(Request $request)
    {
        if($request['name'] == 0){
            return ['msg'=>'请选择'];
        }
        $ser = DB::table('seavers_staff')
            ->where('s_id','=',$request['name'])
            ->select('id','name')
            ->where('status','!=',0)
            ->get();//数据库查询到的服务商数据
        return $ser;
    }

    public function correlate(Request $request)
    {
//        $request['rfp_id'];
//        $request['name'];//服务商id
//        $request['head'];//员工id
        $arr = DB::table("seavers_staff")->select('id','s_id','name')
            ->where('s_id','=',$request['name'])
            ->where('status','!=',0)
            ->get();
        //dd($arr,$request->all());
        if(empty($arr)){
            return ['msg'=>'该服务商未添加员工'];
        }
        //dd($arr[0]['s_id'],$request['name']);
        if($request['name'] = $arr[0]['s_id']){

            if(DB::table('servers')->where('s_id','=',$request['name'])->where('status','!=',0)->where('status','!=',3)->count() == 0){
                return ['msg'=>'此服务商已被停用,请刷新后重新选择'];
            }
            if(DB::table('seavers_staff')->where('id','=',$request['head'])->where('status','!=',0)->count() == 0){
                return ['msg'=>'此员工已被删除,请刷新后重新选择'];
            }
            if(DB::table('rfp_link')->where('rfp_id','=',$request['rfp_id'])->count()>=1){
                return ['msg'=>'服务商信息已存在 不能重复此操作'];
            }else{
                $this->_RfpLink->getNameId($request['rfp_id'],$request['name'],$request['head']);
                //$val = $this -> _Servers ->getHead(); //服务商信息
                return;
            }

        }else{
            return ['msg'=>'服务商与负责人不对应，添加失败'];
        }
    }

}
