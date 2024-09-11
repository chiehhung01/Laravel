<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class ThrottledMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user; 
    public $mail;
    public $tries = 15;
    public $timeout = 10;
    /**
     * Create a new job instance.
     */
    public function __construct(Mailable $mail, User $user)
    {
        $this->mail = $mail;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Redis::throttle('mailtrap')->allow(2)->every(12)->then(function () {
            Mail::to($this->user)->send($this->mail);
     
            // Handle job...
        }, function () {
            // Could not obtain lock...
            return $this->release(5);
        });

        //如果無法獲取到速率限制的鎖，第二個回調函數 function () { return $this->release(5); }
        // 會在 5 秒後重新嘗試執行該 Job，以避免鎖住太長時間。
        //https://laravel.com/docs/10.x/queues#job-middleware
    }
}
