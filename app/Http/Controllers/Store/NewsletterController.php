<?php

declare(strict_types=1);

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\SubscribeNewsletterRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\JsonResponse;

class NewsletterController extends Controller
{
    public function store(SubscribeNewsletterRequest $request): JsonResponse
    {
        $email = $request->validated('email');

        $existing = NewsletterSubscriber::query()
            ->where('email', $email)
            ->exists();

        if (! $existing) {
            NewsletterSubscriber::query()->create([
                'email' => $email,
                'ip_address' => $request->ip(),
                'subscribed_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $existing
                ? 'You are already subscribed to our newsletter.'
                : 'Thanks for subscribing! You will receive our latest deals.',
        ]);
    }
}
