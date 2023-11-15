<?php

namespace Modules\Newsletter\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Newsletter\Entities\Newsletter;

class NewsletterSuccessMail extends Mailable
{

    use Queueable, SerializesModels;

    /**
     * @var \Modules\Newsletter\Entities\Newsletter
     */
    private ?object $newsletter;

    /**
     * Create a new message instance.
     *
     * @param  \Modules\Newsletter\Entities\Newsletter  $newsletter
     */
    public function __construct($newsletter = null)
    {
        $this->newsletter = $newsletter;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('newsletter::mail.subscribe-notification-mail')->with(['newsletter' => $this->newsletter]);
    }
}