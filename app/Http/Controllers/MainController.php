<?php
/**
 * des: 框架页面渲染基础控制器
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view( '/master/main' );
    }
}
