@extends('layouts.admin')

@section('template_title')
    Create Branch
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title" style="font-weight: bold;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Branch - {{$name}}</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('branch.store',['bank'=>$bank,'name'=>$name]) }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('branch.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
