@extends('layouts.admin')

@section('template_title')
    {{ $status->name ?? 'Show Status' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Status</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('status.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Status:</strong>
                            {{ $status->status }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
