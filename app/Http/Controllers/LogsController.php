<?php
/**
 * des: 有关日志处理的控制器
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LogsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view( '/Logs/index' );
    }

    public function detail()
    {
        return view( '/Logs/detail' );
    }
}
