@extends('layouts.app', ['header' => true, 'footer' => true])

@section('content')
<div class="d-flex justify-content-center">
    <div class="elite-page faq col-11">
        <div class="col-12 page-section-wrap">
            <h1 class="page-header" >
                <span class='page-header-title'>Frequently Asked Questions</span>
            </h1>
        </div>

        <div class="page-section-wrap dashboard-section">
            <div class="accordion" id="accordionExample">
                @foreach($faqs as $faq)
                <div class="accordion-item mb-1">
                    <h2 class="accordion-header" id="{{ 'heading-' . $faq->id }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="{{ '#collapse-' . $faq->id }}" aria-expanded="true" aria-controls="{{ 'collapse-' . $faq->id }}">
                            <strong>{{ $faq->question }}</strong>
                        </button>
                    </h2>
                    <div id="{{ 'collapse-' . $faq->id }}" class="accordion-collapse collapse" aria-labelledby="{{ 'heading-' . $faq->id }}" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>{!! $faq->answer !!}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

