@extends('layouts.backend')
@section('content')

<div class="d-flex justify-content-center">
    <div class="content col-10 mt-5" style="border-bottom: 2px solid #f5f5f5;">
        <div class="columns">
            <div class="column">
                <h1>FAQ Content Management</h1>
            </div>
            <div class="column">
                <a href="{{ route('admin.faq.info') }}" class="button is-success is-pulled-right">
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
                    <th>Order</th>
                    <th>Content</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $faqs as $faq)
                <tr>
                    <th>{{ $faq->sorting }}</td>
                    <td>{{ $faq->question }}</td>
                    <td>{{ $faq->status ? 'Published' : 'Draft' }}</td>
                    <td>
                        <a class="button is-small is-link" href="{{ route('admin.faq.info', ['faq' => $faq->id]) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{ route('admin.faq.delete', ['faq' => $faq->id]) }}" title="Delete this incentive" class="button is-small is-danger btn-need-confirm">
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
