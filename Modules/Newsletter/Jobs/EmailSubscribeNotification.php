<?php

namespace Modules\Newsletter\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Modules\Newsletter\Emails\NewsletterSuccessMail;
use Modules\Newsletter\Entities\Newsletter;

class EmailSubscribeNotification implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \Modules\Newsletter\Entities\Newsletter
     */
    private Newsletter $newsletter;

    /**
     * Create a new job instance.
     *
     * @param  \Modules\Newsletter\Entities\Newsletter  $newsletter
     */
    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail = new NewsletterSuccessMail($this->newsletter);
        Mail::to($this->newsletter->email)->send($mail);
    }
}