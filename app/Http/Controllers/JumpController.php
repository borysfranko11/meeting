<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Controller as BaseController;

class JumpController extends BaseController
{
    //
    public function back()
    {
        echo 'back'; exit;
    }

    public function success()
    {
        $this -> authVerify();
        session()->flush();
        session()->save();

        return view( '/jump/success' );
    }
}
