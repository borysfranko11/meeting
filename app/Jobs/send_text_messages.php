<?php

namespace App\Jobs;

use Queue;
use Illuminate\Support\ServiceProvider;
use App\Jobs\Job;
use App\Models\Jobs;
use Illuminate\Contracts\Mail\Mailer;
use App\Models\ParticipantLog;
use App\Models\InvitationSend;
use App\Models\FailedJobs;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

class send_text_messages extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $join_id;
    protected $message;
    protected $tpl_id;
    protected $rfp_id;
    protected $connect;
    protected $session_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($join_id,$message,$tpl_id,$rfp_id,$connect,$session_id)
    {
        $this->join_id = $join_id;
        $this->message = $message;
        $this->tpl_id = $tpl_id;
        $this->rfp_id = $rfp_id;
        $this->connect = $connect;
        $this->session_id = $session_id;        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mess = file_get_contents($this->message);
        $arr = json_decode($mess, true);      
        //file_put_contents('cron.txt',$arr);
        if ($arr['errno'] == 0) {
            $data['join_id'] = $this->join_id;
            $data['send_user'] = $this->session_id;
            $data['send_time'] = date('Y-m-d H:i:s');
            if (empty($tpl_id)) {
                $data['send_type'] = 2;
            } else {
                $data['send_type'] = 1;
            }
            $data['tpl_id'] = $this->tpl_id;
            $data['constom_url'] = $this->connect;
            $data['rfp_id'] = $this->rfp_id;

            DB::table('invitation_send')->insert($data);
            //file_put_contents('./cron.txt',$data);
        } else{
                $message = $this->message;
                $tpl_id = $this->tpl_id;
                $join_id = $this->join_id;
                $rfp_id = $this->rfp_id;
                $connect = $this->connect;
                $session_id = $this->session_id;
            $job = (new send_text_messages($join_id,$message,$tpl_id,$rfp_id,$connect,$session_id));
            $this->dispatch($job);
        }
    }
}
