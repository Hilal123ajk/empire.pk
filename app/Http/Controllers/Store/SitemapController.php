<?php

declare(strict_types=1);

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Services\SitemapService;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __construct(
        private readonly SitemapService $sitemapService,
    ) {}

    public function index(): Response
    {
        return response($this->sitemapService->render(), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    public function generate(): Response
    {
        $path = $this->sitemapService->writeToPublic();

        return response(
            'Sitemap generated at '.$path,
            200,
            ['Content-Type' => 'text/plain; charset=UTF-8'],
        );
    }
}
