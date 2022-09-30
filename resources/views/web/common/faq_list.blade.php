<div class="faq_inner">
    <div class="accordion" id="accordionExample">
        @forelse($faqs as $index => $faq)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{$faq->faq_id}}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->faq_id}}" aria-expanded="true" aria-controls="collapse{{$faq->faq_id}}">
                    {{$faq->title}}
                </button>
            </h2>
            <div id="collapse{{$faq->faq_id}}" class="accordion-collapse collapse show" aria-labelledby="heading{{$faq->faq_id}}" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    @if($faq->descp)
                        <p>{!! nl2br($faq->descp) !!}</p>
                    @endif
                </div>
            </div>
        </div>
        @empty
        @endforelse
    </div>
</div>