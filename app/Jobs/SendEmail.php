<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * mail template
     */
    protected $mailTemplate;

    /**
     * mail data
     */
    protected $mailData;

    /**
     * mail receiver
     */
    protected $mailReceiver;

    /**
     * mail subject
     */
    protected $mailSubject;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mailTemplate, $mailData, $mailReceiver, $mailSubject)
    {
        $this->mailTemplate = $mailTemplate;
        $this->mailData = $mailData;
        $this->mailReceiver = $mailReceiver;
        $this->mailSubject = $mailSubject;
    }

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $retryAfter = 3;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $senderEmail = isset($this->mailData['sender_email']) ? $this->mailData['sender_email'] : config('mail.form.address');
        $senderName = isset($this->mailData['sender_name']) ? $this->mailData['sender_name'] : config('mail.form.name');

        $rsm2 = Mail::send($this->mailTemplate, ['mailData' => $this->mailData], function ($m) use ($senderEmail, $senderName) {
            $m->from($senderEmail, $senderName);
            $m->to($this->mailReceiver, '')->subject($this->mailSubject);
        });

        if (Mail::failures()) {
            Log::error('[SendEmailJobs:' . __LINE__ . 'object =>' . $this->mailSubject . ', receiver =>' . $this->mailReceiver . '] Sending email has been failed!');
        } else {
            Log::info('[SendEmailJobs: object =>' . $this->mailSubject . ', receiver =>' . $this->mailReceiver . '] Sending email successfully!');
        }
    }
}
