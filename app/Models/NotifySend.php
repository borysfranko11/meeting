<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Exception;
use \DB;

class NotifySend extends Model
{
    protected $table = "notify_send";
    public $timestamps = false;
}