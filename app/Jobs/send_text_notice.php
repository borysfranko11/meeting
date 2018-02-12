<?php

namespace App\Jobs;

use Queue;
use Illuminate\Support\ServiceProvider;
use App\Jobs\Job;
use App\Models\Jobs;
use App\Models\NotifySend;
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

class send_text_notice extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $join_id;
    protected $message;
    protected $rfp_id;
    protected $connect;
    protected $session_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($join_id,$message,$rfp_id,$connect,$session_id)
    {
        $this->join_id = $join_id;
        $this->message = $message;
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
            $data['constom_url'] = $this->connect;
            $data['rfp_id'] = $this->rfp_id;

            DB::table('notify_send')->insert($data);
            //file_put_contents('./cron.txt',$data);
        } else{
                $message = $this->message;
                $join_id = $this->join_id;
                $rfp_id = $this->rfp_id;
                $connect = $this->connect;
                $session_id = $this->session_id;
            $job = (new send_text_notice($join_id,$message,$rfp_id,$connect,$session_id));
            $this->dispatch($job);
        }
    }
}
