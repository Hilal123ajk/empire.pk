@props(['seo'])

@php
    /** @var \App\Support\SeoMeta $seo */
    $ogImage = $seo->ogImage;
@endphp

<title>{{ $seo->pageTitle() }}</title>

<meta name="title" content="{{ $seo->title }}">
<meta name="description" content="{{ $seo->description }}">
@if ($seo->keywords)
    <meta name="keywords" content="{{ $seo->keywords }}">
@endif

<link rel="canonical" href="{{ $seo->canonical }}">

<meta property="og:site_name" content="Empire.pk">
<meta property="og:locale" content="en_PK">
<meta property="og:type" content="{{ $seo->ogType }}">
<meta property="og:title" content="{{ $seo->title }}">
<meta property="og:description" content="{{ $seo->description }}">
<meta property="og:url" content="{{ $seo->canonical }}">
@if ($ogImage)
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:alt" content="{{ $seo->title }}">
@endif

<meta name="twitter:card" content="{{ $ogImage ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $seo->title }}">
<meta name="twitter:description" content="{{ $seo->description }}">
@if ($ogImage)
    <meta name="twitter:image" content="{{ $ogImage }}">
    <meta name="twitter:image:alt" content="{{ $seo->title }}">
@endif

@if ($seo->jsonLd)
    <script type="application/ld+json">{!! json_encode($seo->jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}</script>
@endif
