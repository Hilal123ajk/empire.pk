<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\AdminLoginOtpMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAdminLoginOtp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 60;

    public function __construct(
        public readonly int $userId,
        public readonly string $otp,
    ) {}

    public function handle(): void
    {
        $user = User::query()->find($this->userId);

        if ($user === null || ! $user->isAdminUser()) {
            return;
        }

        $ttlMinutes = (int) config('empire.admin_otp_expiry_minutes', 15);

        Mail::to($user->email)->send(new AdminLoginOtpMail(
            userName: $user->name,
            otp: $this->otp,
            expiresMinutes: $ttlMinutes,
        ));
    }
}
