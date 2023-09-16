@extends('layouts.admin')

@section('template_title')
    {{ $transaction->name ?? 'Show Transaction' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Transaction</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('bill.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Client Id:</strong>
                            {{ $transaction->client_id }}
                        </div>
                        <div class="form-group">
                            <strong>Description:</strong>
                            {{ $transaction->description }}
                        </div>
                        <div class="form-group">
                            <strong>Date:</strong>
                            {{ $transaction->date }}
                        </div>
                        <div class="form-group">
                            <strong>Type:</strong>
                            {{ $transaction->type }}
                        </div>
                        <div class="form-group">
                            <strong>Amount:</strong>
                            {{ $transaction->amount }}
                        </div>
                        <div class="form-group">
                            <strong>Units:</strong>
                            {{ $transaction->units }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
