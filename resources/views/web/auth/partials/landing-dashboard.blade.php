@php
    $landingSlug = $landingSlug ?? \Illuminate\Support\Str::slug($title ?? 'dashboard');
    $breadcrumbRoute = $breadcrumbRoute ?? 'user.auth-dashboard';
    $breadcrumbLabel = $breadcrumbLabel ?? 'dashboard';
    $description = $description ?? '';
    $eyebrow = $eyebrow ?? '';
    $eyebrowIcon = $eyebrowIcon ?? 'fa-solid fa-chart-line';
    $highlights = $highlights ?? [];
    $cards = $cards ?? [];
@endphp

<style>
    .landing-shell-{{ $landingSlug }} {
        display: grid;
        gap: 18px;
    }

    .landing-shell-{{ $landingSlug }} .landing-hero {
        background: linear-gradient(135deg, #f4fbf6 0%, #ffffff 100%);
        border: 1px solid #dcece1;
        border-radius: 22px;
        padding: 24px;
        box-shadow: 0 12px 28px rgba(18, 119, 62, 0.06);
    }

    .landing-shell-{{ $landingSlug }} .landing-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #e8f5ed;
        color: #12773E;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .landing-shell-{{ $landingSlug }} .landing-copy {
        max-width: 760px;
        margin: 0;
        color: #667085;
        font-size: 15px;
        line-height: 1.65;
    }

    .landing-shell-{{ $landingSlug }} .landing-highlights {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .landing-shell-{{ $landingSlug }} .landing-highlight {
        padding: 14px 16px;
        border-radius: 18px;
        background: #ffffff;
        border: 1px solid #e4ece7;
    }

    .landing-shell-{{ $landingSlug }} .landing-highlight strong {
        display: block;
        margin-bottom: 4px;
        color: #1f2937;
        font-size: 14px;
        font-weight: 600;
    }

    .landing-shell-{{ $landingSlug }} .landing-highlight span {
        display: block;
        color: #667085;
        font-size: 13px;
        line-height: 1.5;
    }

    .landing-shell-{{ $landingSlug }} .all_dash {
        padding-left: 0;
    }

    .landing-shell-{{ $landingSlug }} .all_dash ul {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    @media only screen and (max-width: 991px) {
        .landing-shell-{{ $landingSlug }} .landing-hero {
            padding: 18px;
            border-radius: 18px;
        }

        .landing-shell-{{ $landingSlug }} .landing-copy {
            font-size: 14px;
            line-height: 1.6;
        }

        .landing-shell-{{ $landingSlug }} .landing-highlights,
        .landing-shell-{{ $landingSlug }} .all_dash ul {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="landing-shell-{{ $landingSlug }}">
    <section class="landing-hero">
        @if ($eyebrow)
            <span class="landing-eyebrow">
                <i class="{{ $eyebrowIcon }}"></i>
                {{ $eyebrow }}
            </span>
        @endif
        <h1 class="page_heading">{{ $title }}</h1>
        <p class="landing-copy">{{ $description }}</p>
    </section>

    @if (!empty($highlights))
        <section class="landing-highlights" aria-label="{{ $title }} highlights">
            @foreach ($highlights as $highlight)
                <article class="landing-highlight">
                    <strong>{{ $highlight['title'] }}</strong>
                    <span>{{ $highlight['description'] }}</span>
                </article>
            @endforeach
        </section>
    @endif

    <div class="all_dash">
        <ul>
            @foreach ($cards as $card)
                @include('web.auth.partials.dashboard-card', $card)
            @endforeach
        </ul>
    </div>
</div>
