@extends('layouts.admin')

@section('template_title')
Transaction
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            <strong>Bills</strong>
                        </span>

                        <div class="float-right">
                            <a href="{{ route('bill.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                <i class="fa fa-plus" aria-hidden="true"></i> Create New Bill
                            </a>
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="card-body">
                    <a href="{{ route('run.bill') }}" class="btn btn-warning btn-lg float-left"  data-placement="left">
                        Run Bills <i class="fa fa-rocket" aria-hidden="true"></i>
                    </a>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>

                                    <th>Client</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                 
                                    <th>Amount</th>
                                    <th>Units</th>

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ ++$i }}</td>

                                    <td>{{ $transaction->account_name }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ $transaction->date }}</td>
                                  
                                    <td>{{ $transaction->amount }}</td>
                                    <td>{{ $transaction->units }}</td>

                                    <td>
                                        <form action="{{ route('bill.destroy',$transaction->id) }}" method="POST">
                                            @can('billing_access')
                                            <a class="btn btn-sm btn-success" href="{{ route('bill.edit',$transaction->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                            @endcan
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
