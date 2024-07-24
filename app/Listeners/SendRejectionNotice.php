<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Events\ArticleRejected;
use App\Mail\Rejected;

class SendRejectionNotice
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ArticleRejected $event): void
    {
        $writer = $event->article->user->email;
        Mail::to($writer)->send(new Rejected($event->article));
    }
}
