<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\User;
use App\Services\AdminOtpService;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;

class SendAdminLoginOtp
{
    use Dispatchable, Queueable, SerializesModels;

    public function __construct(
        public readonly int $userId,
    ) {}

    public function handle(AdminOtpService $otp): void
    {
        $user = User::query()->find($this->userId);

        if ($user === null || ! $user->isAdminUser()) {
            return;
        }

        $otp->sendOtp($user);
    }
}
