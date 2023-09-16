@extends('layouts.admin')

@section('template_title')
    {{ $legalCenter->name ?? 'Show Legal Center' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Legal Center</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('legal-centers.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Center:</strong>
                            {{ $legalCenter->center }}
                        </div>
                        <div class="form-group">
                            <strong>Amount:</strong>
                            {{ $legalCenter->amount }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
