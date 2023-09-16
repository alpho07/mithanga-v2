@extends('layouts.admin')

@section('template_title')
    Create Settings Nbrd
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Create Settings Nbrd</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('settings_nbrd.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('settings-nbrd.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
