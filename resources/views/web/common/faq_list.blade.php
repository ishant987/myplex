<div class="faq_inner">
    <div class="accordion" id="accordionExample">
        @forelse($faqs as $index => $faq)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{ data_get($faq, 'faq_id', $index) }}">
                <button class="accordion-button {{ ($index == 0)?'':' collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ data_get($faq, 'faq_id', $index) }}" aria-expanded="{{ ($index == 0)?'true':'false' }}" aria-controls="collapse{{ data_get($faq, 'faq_id', $index) }}">
                    {{ data_get($faq, 'title', 'FAQ item') }}
                </button>
            </h2>
            <div id="collapse{{ data_get($faq, 'faq_id', $index) }}" class="accordion-collapse collapse {{ ($index == 0)?' show':'' }}" aria-labelledby="heading{{ data_get($faq, 'faq_id', $index) }}" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    @if(data_get($faq, 'descp'))
                        <p>{!! nl2br(data_get($faq, 'descp')) !!}</p>
                    @endif
                </div>
            </div>
        </div>
        @empty
        @endforelse
    </div>
</div>
