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
                            <strong>Reconciled Payments</strong>
                        </span>
                         <div class="float-right">
                              <a href="{{ route('mobile_transactions.stray') }}{{$q}}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                 Stray Payments
                            </a>
                            <a href="{{ route('mobile_transactions.index') }}{{$q}}" class="btn btn-warning btn-sm float-right"  data-placement="left">
                                Reconciled Payments
                            </a>
                       

                        </div>
                       
                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif



    <!-- Search Form -->
    <form action="{{ route('transactions.search') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search by TransID or Transaction Type">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <!-- Transaction Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>M-PESA Code</th>
                <th>Account</th>                
                <th>Date Time</th>                
                <th>Customer</th>
                <th>Phone Number</th>
                <th style="text-align: right; ">Amount(KES)</th>
               
                
                <!-- Add other table headers for columns -->
            </tr>
        </thead>
        <tbody>
               @php
             $amount = 0
             @endphp
            @foreach ($transactions as $transaction)
             @php
             $amount = $amount + $transaction->TransAmount; 
             @endphp
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->TransID }}</td>
                    <td>{{ $transaction->BillRefNumber }}</td>
                    <td>{{ $transaction->TransTime }}</td>                    
                    <td>{{ $transaction->FirstName.' '.$transaction->MiddleName.' '.$transaction->LastName }}</td>
                    <td>{{ str_replace('254','0',$transaction->MSISDN)}}</td>
                    <td style="text-align: right;font-weight: bold;">{{ number_format($transaction->TransAmount,2) }}</td>
                    <!-- Add other table data for columns -->
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" style="font-weight: bold">Total(KES)</td>
                <td style="font-weight: bold;text-align: right;">{{number_format($amount,2)}}</td>
            </tr>
        </tfoot>
    </table>

    <!-- Pagination Links -->
    {{ $transactions->links() }}
</div>


                
                
                
                </div>
            </div>

        </div>
 



@endsection
