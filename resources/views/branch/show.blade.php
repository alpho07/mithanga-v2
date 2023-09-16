@extends('layouts.admin')

@section('template_title')
    {{ $branch->name ?? 'Show Branch' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Branch</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('branch.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $branch->name }}
                        </div>
                        <div class="form-group">
                            <strong>Bank Id:</strong>
                            {{ $branch->bank_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
