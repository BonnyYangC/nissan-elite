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
                    <a href="{{ route('admin.faqs') }}" class="button is-pulled-right is-primary">Go Back</a>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="card  mt-20">
                <div class="card-content">
                    <div class="content">
                        <form action="{{ route('admin.faq.edit') }}" method="post" class="form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $faq ? $faq->id : '' }}">
                            <h2 class="m-4"> {{ $faq ? $faq->title : '' }}</h2>
                            <hr>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Question</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="text" name="question" placeholder="Question" value="{{ $faq ? $faq->question : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Order</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="text" name="sorting" placeholder="Order" value="{{ $faq ? $faq->sorting : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Status</label>
                                </div>
                                <div class="field-body">
                                    <div class="field is-narrow">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select name="status">
                                                    <option value="0" {{ $faq && !$faq->status ? 'selected' : null }}>Draft</option>
                                                    <option value="1" {{ $faq && $faq->status ? 'selected' : null }}>Published</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Answer</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <textarea class="textarea" name="answer" placeholder="Required: Answer" id="summernote" cols="30" rows="10">{{ $faq ? $faq->answer : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="field is-horizontal">
                                <div class="field-label">
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <button class="button is-primary" type="submit">
                                                <i id="submit-btn-waiting" class="fas fa-database"></i>&nbsp;&nbsp;&nbsp;
                                                <span id="submit-btn-txt">Submit</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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
