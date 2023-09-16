@extends('layouts.admin')

@section('template_title')
    Create Bank
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Create Bank</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('bank.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('bank.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
