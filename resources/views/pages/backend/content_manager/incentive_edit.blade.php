@extends('layouts.backend')
@section('content')
<div class="d-flex justify-content-center">

    <div class="container mt-5">
        <div class="content mt-20">
            <div class="columns">
                <div class="column">
                    <h1>Incentive</h1>
                </div>
                <div class="column">
                    <a href="{{ route('admin.incentives') }}" class="button is-pulled-right is-primary">Go Back</a>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="card  mt-20">
                <div class="card-content">
                    <div class="content">
                        <form action="{{ route('admin.incentive.edit') }}" method="post" class="form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $incentive ? $incentive->id : '' }}">
                            <h2 class="m-4"> {{ $incentive ? $incentive->title : '' }}</h2>
                            <hr>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Title</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="text" name="title" placeholder="Title" value="{{ $incentive ? $incentive->title : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Region</label>
                                </div>
                                <div class="field-body">
                                    <div class="field is-narrow">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select name="region">
                                                    <option value="All" {{ $incentive && $incentive->region=='All'?'selected':null }}>All</option>
                                                    <option value="Eastern" {{ $incentive && $incentive->region=='Eastern'?'selected':null }}>Eastern</option>
                                                    <option value="Northern" {{ $incentive && $incentive->region=='Northern'?'selected':null }}>Northern</option>
                                                    <option value="Southern" {{ $incentive && $incentive->region=='Southern'?'selected':null }}>Southern</option>
                                                    <option value="Western" {{ $incentive && $incentive->region=='Western'?'selected':null }}>Western</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Start At</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="date" name="start" placeholder="Start at" value="{{ $incentive ? $incentive->start : null }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">End At</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="date" name="finish" placeholder="End at" value="{{ $incentive ? $incentive->finish : null}}">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Caption</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="text" name="caption" placeholder="Optional: caption" value="{{ $incentive ? $incentive->caption : '' }}">
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
                                        @if($incentive->image)
                                        <img src="{{ asset('/elite/incentives/images/'.$incentive->image) }}" alt="" width="200" class="thumbnail">
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
                                        @if($incentive->pdf)
                                        <a class="button is-link" href="{{ asset('/elite/incentives/pdfs/'.$incentive->pdf) }}" target="_blank">
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
