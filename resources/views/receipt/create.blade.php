@extends('layouts.admin')

@section('template_title')
    Client Receipt
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">New Client</span>
                    </div>
                    <div class="card-body" style="background: #E3F2FD">
                        <form method="POST" action="{{ route('client.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('client.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
