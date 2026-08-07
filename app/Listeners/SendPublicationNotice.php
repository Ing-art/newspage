<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ArticlePublished;
use Illuminate\Support\Facades\Mail;
use App\Mail\Published;

class SendPublicationNotice implements ShouldQueue
{
    use InteractsWithQueue;

    public int $tries = 3;

    public function backoff(): array
    {
        return [5, 15, 30];
    }

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
    public function handle(ArticlePublished $event):void
    {
        $writer = $event->article->user->email;
        Mail::to($writer)->send(new Published($event->article));
        
    }
}
