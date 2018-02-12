<?php
/**
 * Created by PhpStorm.
 * User: xp
 * Date: 2017/9/12
 * Time: 16:49
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Exception;
use App\Libs\EveClient;


class MessageController extends Controller
{
    private $userInfo;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->userInfo = $request->session()->get('user');
        $this->EveClient = new EveClient();

    }

    /**
     * @desc 获取留言
     * @param Request $request
     */
    public function getMessage(Request $request)
    {
        $result = [];
        try {
            $mapId = $request->input('mapId', false);
            $data['map_id'] = $mapId;

            $this->open_api();
            $array['signature'] = $this->eveClient->generateSign($data);
            $array['param'] = json_encode($data);

            $result = $this->http->httpget(config('links.open_api_url') . '/Monarch/get_company_rfp_message?', $array, $this->token);
            $result = $this->clearData($result);

            return returnJson(true, $result);
        } catch (Exception $e) {
            return returnJson(true, $result);
        }
    }

    /**
     * @desc 保存留言
     * @param Request $request
     */
    public function saveMessage(Request $request)
    {
        $mapId = $request->input('mapId', false);
        $msg = $request->input('msg', false);
        $data['map_id'] = $mapId;
        $data['user_id'] = $this->userInfo['id'];
        $data['msg'] = $msg;
        $data['from'] = 1;

        $this->open_api();
        $array['signature'] = $this->eveClient->generateSign($data);
        $array['param'] = json_encode($data);


        $result = $this->http->httpget(config('links.open_api_url') . '/Monarch/insert_rfp_message?', $array, $this->token);
        $result = $this->clearData($result);
        if ($result > 0) {
            return returnJson(true, $result);
        }

        return returnJson(false, $result);
    }

    private function clearData($data)
    {
        $data = json_decode($data, true);
        if (is_null($data)) {
            throw  new Exception("木有数据", '-1');
        }

        if (!isset($data['data']) || empty($data['data'])) {
            return [];
        }

        return $data['data'];
    }
}