<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class FailedSms extends Base
{
    //
    protected  $table = 'failed_sms';
    const CREATED_AT = 'creation_at';
}