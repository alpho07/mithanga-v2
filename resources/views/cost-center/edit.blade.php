@extends('layouts.admin')
@section('template_title')
    Update Cost Center
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Cost Center</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('cost-centers.update', $costCenter->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('cost-center.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
