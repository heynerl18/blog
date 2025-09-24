@props(['post'])

@php
  $firstImage = $post->media->where('file_type', '!=', 'video/mp4')->first();
  $video = $post->media->firstWhere('file_type', 'video/mp4');

  $imageUrl = $firstImage ? (str_starts_with($firstImage->url, 'http') ? $firstImage->url : url($firstImage->url)) : null;
  $videoUrl = $video ? (str_starts_with($video->url, 'http') ? $video->url : url($video->url)) : null;

  $description = Str::limit(strip_tags($post->content), 160);
  $longDescription = Str::limit(strip_tags($post->content), 300);
  $twitterDescription = Str::limit(strip_tags($post->content), 200);
  $keywords = $post->tags->pluck('name')->implode(', ');
  $authorName = $post->user->name ?? 'Autor';
  $secureImageUrl = $imageUrl ? str_replace('http://', 'https://', $imageUrl) : null;
  $secureVideoUrl = $videoUrl ? str_replace('http://', 'https://', $videoUrl) : null;
@endphp

{{-- Meta etiquetas básicas para SEO --}}
<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="{{ $authorName }}">

{{-- Open Graph para Facebook --}}
<meta property="og:title" content="{{ $post->title }}">
<meta property="og:description" content="{{ $longDescription }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="article">
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:locale" content="es_ES">

{{-- Imagen para compartir optimizada --}}
@if ($imageUrl)
  <meta property="og:image" content="{{ $imageUrl }}">
  <meta property="og:image:secure_url" content="{{ $secureImageUrl }}">
  <meta property="og:image:alt" content="{{ $post->title }}">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:image:type" content="image/jpeg">
@else
  {{-- Imagen por defecto --}}
  <meta property="og:image" content="{{ url('images/default-share-image.jpg') }}">
  <meta property="og:image:secure_url" content="{{ secure_url('images/default-share-image.jpg') }}">
  <meta property="og:image:alt" content="{{ config('app.name') }} - {{ $post->title }}">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:image:type" content="image/jpeg">
@endif

{{-- Si hay video --}}
@if ($videoUrl)
  <meta property="og:video" content="{{ $videoUrl }}">
  <meta property="og:video:secure_url" content="{{ $secureVideoUrl }}">
  <meta property="og:video:type" content="video/mp4">
  <meta property="og:video:width" content="1200">
  <meta property="og:video:height" content="630">
@endif

{{-- Información del artículo --}}
<meta property="article:author" content="{{ $authorName }}">
<meta property="article:published_time" content="{{ $post->created_at->toISOString() }}">
@if ($post->updated_at != $post->created_at)
  <meta property="article:modified_time" content="{{ $post->updated_at->toISOString() }}">
@endif

{{-- Tags del artículo --}}
@foreach ($post->tags as $tag)
  <meta property="article:tag" content="{{ $tag->name }}">
@endforeach

{{-- Twitter Cards --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $post->title }}">
<meta name="twitter:description" content="{{ $twitterDescription }}">
@if ($imageUrl)
  <meta name="twitter:image" content="{{ $imageUrl }}">
@endif

{{-- Schema.org estructurado para Google --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "{{ $post->title }}",
  "description": "{{ $twitterDescription }}",
  "author": {
    "@type": "Person",
    "name": "{{ $authorName }}"
  },
  "publisher": {
    "@type": "Organization",
    "name": "{{ config('app.name') }}"
  },
  "datePublished": "{{ $post->created_at->toISOString() }}",
  "dateModified": "{{ $post->updated_at->toISOString() }}",
  @if ($imageUrl)
  "image": "{{ $imageUrl }}",
  @endif
  "url": "{{ url()->current() }}"
}
</script>