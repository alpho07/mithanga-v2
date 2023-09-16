@extends('layouts.admin')

@section('template_title')
    Update Branch
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title"><strong>Update {{$name}}'s Branch</strong></span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('branch.update', ['id'=>$branch->id,'bank'=>$bank,'name'=>$name]) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('branch.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
