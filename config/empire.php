<?php

declare(strict_types=1);

return [
    'free_delivery_minimum' => 2500,
    'standard_delivery_fee' => 199,

    /*
    | Category slugs eligible for free delivery (mobile cases & covers).
    | Slugs containing any pattern below also qualify.
    */
    'free_delivery_category_slugs' => [
        'cases-covers',
        'phone-cases',
        'iphone-cases',
        'mobile-cases',
    ],

    'free_delivery_category_patterns' => [
        'case',
        'cover',
    ],

    'admin_otp_valid_days' => 7,
    'admin_otp_expiry_minutes' => 15,
];
