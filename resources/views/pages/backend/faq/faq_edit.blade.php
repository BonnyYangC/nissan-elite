@extends('layouts.backend')
@section('content')
<div class="d-flex justify-content-center">

    <div class="container mt-5">
        <div class="content mt-20">
            <div class="columns">
                <div class="column">
                    <h1>FAQ</h1>
                </div>
                <div class="column">
                    <a href="{{ route('faqs.index') }}" class="button is-pulled-right is-primary">Go Back</a>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="card  mt-20">
                <div class="card-content">
                @if ($faq)
                    @include('pages.backend.faq.partial.edit')
                @else
                    @include('pages.backend.faq.partial.create')
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 500,
        });
    });
</script>
