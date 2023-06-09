@extends('layouts.backend')
@section('content')

<div class="d-flex justify-content-center">
    <div class="content col-10 mt-5" style="border-bottom: 2px solid #f5f5f5;">
        <div class="columns">
            <div class="column">
                <h1>News Management</h1>
            </div>
            <div class="column">
                <a href="{{ route('admin.news.info') }}" class="button is-success is-pulled-right">
                    <i class="fa fa-plus"></i>&nbsp;New
                </a>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-3 m-5">
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-10">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Feature Image</th>
                    <th>Attachment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $news as $n)
                <tr>
                    <td>{{ $n->title }}</td>
                    <td>
                        <img width="120" class="thumbnail" src="{{ asset('/images/news/images/'.$n->image) }}" alt="">
                    </td>
                    <td>
                        <a href="{{ asset('/images/news/pdfs/'.$n->pdf) }}" target="_blank">View PDF</a>
                    </td>
                    <td>
                        <a class="button is-small is-link" href="{{ route('admin.news.info', ['news' => $n->id]) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{ route('admin.news.delete', ['news' => $n->id]) }}" title="Delete this news" class="button is-small is-danger btn-need-confirm">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
