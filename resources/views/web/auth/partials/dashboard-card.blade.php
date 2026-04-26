<li>
    <a href="{{ route($route) }}" class="dashboard_card">
        <figure>
            <img src="{{ asset($icon) }}" alt="{{ $title }}">
        </figure>
        <div class="dashboard_card_text">
            <span class="dashboard_card_title">{{ $title }}</span>
            <span class="dashboard_card_subtitle">{{ $subtitle }}</span>
        </div>
        <span class="dashboard_card_arrow" aria-hidden="true">
            <i class="fa-solid fa-angle-right"></i>
        </span>
    </a>
</li>
