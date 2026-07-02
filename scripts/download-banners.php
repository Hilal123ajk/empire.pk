<?php

declare(strict_types=1);

$dir = __DIR__.'/../public/images/banners';

if (! is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$files = [
    'iphone-accessories.jpg' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=1400&h=500&fit=crop',
    'summer-sale.jpg' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=1400&h=500&fit=crop',
    'furniture.jpg' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=1400&h=500&fit=crop',
    'cases-covers.jpg' => 'https://images.unsplash.com/photo-1616348436168-de43ad0db179?w=1400&h=500&fit=crop',
];

foreach ($files as $name => $url) {
    $context = stream_context_create([
        'http' => ['header' => "User-Agent: Empire.pk/1.0\r\n"],
    ]);

    $data = @file_get_contents($url, false, $context);

    if ($data === false) {
        echo "FAIL {$name}\n";
        continue;
    }

    file_put_contents($dir.'/'.$name, $data);
    echo 'OK '.$name.' '.strlen($data)." bytes\n";
}
