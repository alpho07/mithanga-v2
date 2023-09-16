@extends('layouts.admin')

@section('template_title')
    Update Settings Dpm
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Settings Dpm</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('settings_dpm.update', $settingsDpm->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('settings-dpm.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
