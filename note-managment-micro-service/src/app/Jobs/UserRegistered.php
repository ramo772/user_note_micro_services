<?php

namespace App\Jobs;

use App\Models\UserToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Hash;

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

        $hashed_token =   hash('sha256',$this->accessToken);
        UserToken::updateOrCreate(
            [
                'user_id' => $this->userId,
            ],
            [
                'token' => $hashed_token,
                'expires_at' => $this->tokenExpiration
            ]
        );
    }
}
