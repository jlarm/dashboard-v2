<?php

namespace App\Jobs;

use App\Mail\InviteMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendQueueEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $invite;
    public function __construct($invite)
    {
        $this->invite = $invite;
    }

    public function handle()
    {
        Mail::to($this->invite->email)->send(new InviteMail($this->invite));
    }
}
