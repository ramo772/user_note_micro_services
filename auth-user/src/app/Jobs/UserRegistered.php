<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserRegistered implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $userId, protected $accessToken, protected $tokenExpiration)
    {
        $this->userId = $userId;
        $this->accessToken = $accessToken;
        $this->tokenExpiration = $tokenExpiration;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
    }
}
