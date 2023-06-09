@extends('layouts.backend')
@section('content')
<div class="d-flex justify-content-center">

    <div class="container mt-5">
        <div class="content mt-20">
            <div class="columns">
                <div class="column">
                    <h1>News</h1>
                </div>
                <div class="column">
                    <a href="{{ route('admin.news') }}" class="button is-pulled-right is-primary">Go Back</a>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="card  mt-20">
                <div class="card-content">
                    <div class="content">
                        <form action="{{ route('admin.news.edit') }}" method="post" class="form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $news ? $news->id : '' }}">
                            <h2 class="m-4"> {{ $news ? $news->title : '' }}</h2>
                            <hr>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Title</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="text" name="title" placeholder="Title" value="{{ $news ? $news->title : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Image</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <div class="file has-name">
                                                <label class="file-label">
                                                    <input id="csv-file-input" class="file-input" type="file" name="image">
                                                    <span class="file-cta">
                                                          <span class="file-icon">
                                                            <i class="fas fa-upload"></i>
                                                          </span>
                                                          <span class="file-label">
                                                            Choose a file…
                                                          </span>
                                                    </span>
                                                    <span class="file-name" id="csv-file-input-text" style="min-width: 450px;">
                                                        Max file size: 2M
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <p>
                                        @if($news->image)
                                        <img src="{{ asset('/images/news/images/'.$news->image) }}" alt="" width="200" class="thumbnail">
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">PDF</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <div class="file has-name">
                                                <label class="file-label">
                                                    <input id="pdf-file-input" class="file-input" type="file" name="pdf">
                                                    <span class="file-cta">
                                                          <span class="file-icon">
                                                            <i class="fas fa-upload"></i>
                                                          </span>
                                                          <span class="file-label">
                                                            Choose a file…
                                                          </span>
                                                    </span>
                                                    <span class="file-name" id="pdf-file-input-text" style="min-width: 450px;">
                                                        Max file size: 2M
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <p>
                                        @if($news->pdf)
                                        <a class="button is-link" href="{{ asset('/images/news/pdfs/'.$news->pdf) }}" target="_blank">
                                            View PDF
                                        </a>
                                        @endif
                                    </p>
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
