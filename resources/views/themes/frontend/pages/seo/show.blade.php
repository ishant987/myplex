@extends('web.layout.app')

@section('page-title'){{ $page->seo_title ?: $page->page_title }}@stop
@section('meta-title'){{ $page->seo_title ?: $page->page_title }}@stop
@section('meta-description'){{ $page->meta_description ?: $page->short_description }}@stop
@section('meta-image'){{ $page->og_image_url ?: $page->featured_image_url }}@stop
@section('cur-url'){{ $page->canonical_url ?: $page->public_url }}@stop

@section('canonical')
<meta name="robots" content="{{ $page->is_indexed ? 'index, follow' : 'noindex, nofollow' }}">
<script type="application/ld+json">{!! json_encode(["@context"=>"https://schema.org","@type"=>$page->schema_type ?: "BlogPosting","headline"=>$page->page_title,"description"=>$page->meta_description ?: $page->short_description,"author"=>["@type"=>"Person","name"=>$page->author],"datePublished"=>optional($page->publish_date)->toDateString(),"image"=>$page->featured_image_url,"publisher"=>["@type"=>"Organization","name"=>"MyPlexus","url"=>"https://www.myplexus.com"]]) !!}</script>
<script type="application/ld+json">{!! json_encode(["@context"=>"https://schema.org","@type"=>"BreadcrumbList","itemListElement"=>[["@type"=>"ListItem","position"=>1,"name"=>"Home","item"=>"https://www.myplexus.com"],["@type"=>"ListItem","position"=>2,"name"=>$page->category,"item"=>"https://www.myplexus.com"],["@type"=>"ListItem","position"=>3,"name"=>$page->page_title,"item"=>$page->public_url]]]) !!}</script>
@stop

@push('style')
<style>
  .seo-page {
    background: #fff;
    color: #343434;
  }

  .seo-hero {
    position: relative;
    padding: 120px 0 70px;
    background: #ebf6f0;
    overflow: hidden;
  }

  .seo-hero:before {
    content: "";
    position: absolute;
    inset: 0;
    background-image: url('{{ asset('themes/frontend/assets/images/green-gradient-bg-2.jpg') }}');
    background-repeat: no-repeat;
    background-size: cover;
    opacity: .28;
  }

  .seo-hero .container {
    position: relative;
    z-index: 1;
  }

  .seo-breadcrumb {
    color: #00665e;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 24px;
  }

  .seo-breadcrumb a {
    color: #00665e;
  }

  .seo-hero h1 {
    color: #191b1a;
    font-size: 54px;
    line-height: 1.08;
    font-weight: 700;
    margin-bottom: 24px;
  }

  .seo-excerpt {
    max-width: 720px;
    color: #414345;
    font-size: 19px;
    line-height: 1.8;
    margin-bottom: 30px;
  }

  .seo-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    color: #fff;
    margin-bottom: 32px;
  }

  .seo-meta span {
    display: inline-block;
    background: #379962;
    border-radius: 2px;
    padding: 9px 14px;
    font-size: 14px;
    font-weight: 600;
  }

  .seo-hero-img {
    position: relative;
    border-radius: 4px;
    overflow: hidden;
    box-shadow: 2px 18px 35px -12px #00000045;
    background: #fff;
  }

  .seo-hero-img img {
    width: 100%;
    height: 430px;
    object-fit: cover;
    display: block;
  }

  .seo-summary-band {
    margin-top: -34px;
    position: relative;
    z-index: 2;
  }

  .seo-summary-grid {
    background: #fff;
    border: 1px solid #e4ebe7;
    box-shadow: 0 19px 43px #e5ede8;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
  }

  .seo-summary-item {
    padding: 28px;
    border-right: 1px solid #e4ebe7;
  }

  .seo-summary-item:last-child {
    border-right: 0;
  }

  .seo-summary-item small {
    display: block;
    color: #379962;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 8px;
  }

  .seo-summary-item strong {
    color: #262223;
    font-size: 18px;
    line-height: 1.45;
  }

  .seo-main {
    padding: 70px 0;
  }

  .seo-layout {
    display: grid;
    grid-template-columns: minmax(0, 760px) 330px;
    gap: 58px;
    align-items: start;
  }

  .seo-article {
    color: #343434;
    font-size: 18px;
    line-height: 1.9;
  }

  .seo-article h1 {
    display: none;
  }

  .seo-article h2 {
    color: #00665e;
    font-size: 34px;
    line-height: 1.22;
    font-weight: 700;
    margin: 50px 0 18px;
  }

  .seo-article h3 {
    color: #191b1a;
    font-size: 25px;
    font-weight: 700;
    margin: 34px 0 14px;
  }

  .seo-article p,
  .seo-article li {
    color: #414345;
  }

  .seo-article p {
    margin-bottom: 22px;
  }

  .seo-article a {
    color: #379962;
    font-weight: 700;
  }

  .seo-article blockquote {
    margin: 36px 0;
    padding: 30px 34px;
    background: #ebf6f0;
    border-left: 6px solid #f39c1a;
    color: #191b1a;
    font-size: 22px;
    line-height: 1.65;
  }

  .seo-article figure {
    margin: 42px 0;
  }

  .seo-article figure img {
    width: 100%;
    border-radius: 4px;
    box-shadow: 2px 14px 28px -16px #00000073;
  }

  .seo-article figcaption {
    color: #6b776f;
    font-size: 14px;
    margin-top: 10px;
  }

  .seo-side {
    position: sticky;
    top: 20px;
  }

  .seo-side-box {
    background: #f7f7fb;
    border: 1px solid #e7e4e4;
    padding: 26px;
    margin-bottom: 24px;
    box-shadow: 2px 8px 15px -6px #0000001f;
  }

  .seo-side-box h4 {
    color: #00665e;
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 16px;
  }

  .seo-side-box ul {
    margin: 0;
    padding-left: 18px;
  }

  .seo-side-box li {
    color: #414345;
    margin-bottom: 12px;
    line-height: 1.6;
  }

  .seo-side-img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 4px;
    margin-bottom: 24px;
    box-shadow: 2px 8px 15px -6px #0000001f;
  }

  .seo-visual-strip {
    background: #ebf6f0;
    padding: 70px 0;
  }

  .seo-visual-grid {
    display: grid;
    grid-template-columns: 1.1fr .9fr;
    gap: 30px;
  }

  .seo-visual-grid img {
    width: 100%;
    height: 360px;
    object-fit: cover;
    border-radius: 4px;
    box-shadow: 2px 8px 15px -6px #0000001f;
  }

  .seo-cta {
    background: #00665e;
    color: #fff;
    padding: 54px;
    min-height: 360px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .seo-cta h3 {
    color: #fff;
    font-size: 34px;
    line-height: 1.25;
    margin-bottom: 18px;
  }

  .seo-cta p {
    color: #e8fff3;
    font-size: 17px;
    line-height: 1.8;
    margin-bottom: 24px;
  }

  .seo-cta a {
    align-self: flex-start;
    background: #f39c1a;
    color: #000;
    font-weight: 700;
    padding: 13px 24px;
    border-radius: 2px;
  }

  .seo-related {
    padding: 70px 0;
  }

  .seo-related h2 {
    color: #191b1a;
    font-size: 36px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 34px;
  }

  .seo-related-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
  }

  .seo-related-card {
    display: block;
    height: 100%;
    color: #343434;
    background: #fff;
    border: 1px solid #e4ebe7;
    padding: 26px;
    box-shadow: 0 19px 43px #e5ede8;
  }

  .seo-related-card strong {
    display: block;
    color: #00665e;
    font-size: 21px;
    line-height: 1.35;
    margin-bottom: 12px;
  }

  .seo-related-card span {
    color: #414345;
    line-height: 1.65;
  }

  @media (max-width: 991px) {
    .seo-hero {
      padding-top: 80px;
    }

    .seo-hero h1 {
      font-size: 40px;
    }

    .seo-layout,
    .seo-visual-grid {
      grid-template-columns: 1fr;
    }

    .seo-side {
      position: static;
    }

    .seo-summary-grid,
    .seo-related-grid {
      grid-template-columns: 1fr;
    }

    .seo-summary-item {
      border-right: 0;
      border-bottom: 1px solid #e4ebe7;
    }
  }

  @media (max-width: 575px) {
    .seo-hero h1 {
      font-size: 32px;
    }

    .seo-hero-img img,
    .seo-visual-grid img {
      height: 260px;
    }

    .seo-cta {
      padding: 32px;
      min-height: auto;
    }
  }
</style>
@endpush

@section('content')
<main class="seo-page">
  <section class="seo-hero">
    <div class="container">
      <div class="seo-breadcrumb">
        <a href="{{ url('/') }}">Home</a> &gt; {{ $page->category }} &gt; {{ $page->page_title }}
      </div>
      <div class="row align-items-center">
        <div class="col-lg-7">
          <h1>{{ $page->page_title }}</h1>
          <p class="seo-excerpt">{{ $page->short_description }}</p>
          <div class="seo-meta">
            @if($page->author)<span>By {{ $page->author }}</span>@endif
            @if($page->publish_date)<span>{{ $page->publish_date->format('M d, Y') }}</span>@endif
            @if($page->category)<span>{{ $page->category }}</span>@endif
          </div>
        </div>
        <div class="col-lg-5">
          <div class="seo-hero-img">
            <img src="{{ $page->featured_image_url ?: ($gallery[0] ?? asset('themes/frontend/assets/images/blog-banner-01.jpg')) }}" alt="{{ $page->image_alt_text ?: $page->page_title }}" loading="lazy" width="620" height="430">
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="seo-summary-band">
    <div class="container">
      <div class="seo-summary-grid">
        <div class="seo-summary-item"><small>Read Time</small><strong>{{ max(6, ceil(str_word_count(strip_tags($page->full_content)) / 220)) }} minutes</strong></div>
        <div class="seo-summary-item"><small>Focus</small><strong>{{ $page->focus_keyword ?: $page->category }}</strong></div>
        <div class="seo-summary-item"><small>Use This For</small><strong>Planning decisions, client education, and mutual fund research context.</strong></div>
      </div>
    </div>
  </section>

  <section class="seo-main">
    <div class="container">
      <div class="seo-layout">
        <article class="seo-article">
          {!! $page->full_content !!}
        </article>
        <aside class="seo-side">
          @foreach(array_slice($gallery, 0, 2) as $image)
          <img class="seo-side-img" src="{{ $image }}" alt="{{ $page->category }} insight image" loading="lazy" width="330" height="220">
          @endforeach
          <div class="seo-side-box">
            <h4>Key Takeaways</h4>
            <ul>
              <li>Start with goals before choosing funds or products.</li>
              <li>Review risk, time horizon, tax impact, and liquidity together.</li>
              <li>Use data and process so investing decisions stay repeatable.</li>
            </ul>
          </div>
          <div class="seo-side-box">
            <h4>Popular Tags</h4>
            <p>{{ $page->tags }}</p>
          </div>
        </aside>
      </div>
    </div>
  </section>

  <section class="seo-visual-strip">
    <div class="container">
      <div class="seo-visual-grid">
        <img src="{{ $gallery[2] ?? asset('themes/frontend/assets/images/graph-image.jpg') }}" alt="{{ $page->category }} data visual" loading="lazy" width="760" height="360">
        <div class="seo-cta">
          <h3>Build decisions with research, not noise.</h3>
          <p>MyPlexus helps investors and advisors compare fund behaviour, understand portfolio movement, and keep long-term plans grounded in useful evidence.</p>
          <a href="{{ url('/') }}">Explore MyPlexus</a>
        </div>
      </div>
    </div>
  </section>

  @if($related->count())
  <section class="seo-related">
    <div class="container">
      <h2>Related Pages</h2>
      <div class="seo-related-grid">
        @foreach($related as $item)
        <a class="seo-related-card" href="{{ url($item->url_slug) }}">
          <strong>{{ $item->page_title }}</strong>
          <span>{{ $item->short_description }}</span>
        </a>
        @endforeach
      </div>
    </div>
  </section>
  @endif
</main>
@stop
