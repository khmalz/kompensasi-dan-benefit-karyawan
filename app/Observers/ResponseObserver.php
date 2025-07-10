<?php

namespace App\Observers;

use App\Models\Response;
use App\Notifications\BenefitNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class ResponseObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Response "created" event.
     */
    public function created(Response $response): void
    {
        $this->sendEmail($response);
    }

    /**
     * Handle the Response "updated" event.
     */
    public function updated(Response $response): void
    {
        $this->sendEmail($response);
    }

    private function sendEmail(Response $response)
    {
        Notification::send($response->benefit->employee->user, new BenefitNotification($response->benefit));
    }
}
