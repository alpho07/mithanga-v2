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
                            <strong>Disconnected Consumed Units</strong>
                        </span>


                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Client</th>
                                    <th>Area</th>
                                    <th>Date</th>
                                    <th>Units</th>
                                    <th>Rate</th>
                                    <th>Amount</th>                          


                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $units = 0;
                                $amount =0;
                                @endphp
                                @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $transaction->account_name }}</td>
                                    <td>{{ $transaction->area_name }}</td>
                                    <td>{{ explode(' ',$transaction->reading_date)[0] }}</td>
                                    <td>{{ $transaction->consumed_units }}</td>
                                    <td>{{ $transaction->rate }}</td>
                                    <td>{{ number_format($transaction->water_charges,2) }}</td>


                                </tr>
                                @php
                                $units = $units + $transaction->consumed_units;
                                $amount = $amount + $transaction->water_charges;
                                @endphp
                                @endforeach
                                <tr>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>{{$units }}</th>
                                    <th></th>
                                    <th>{{ number_format($amount,2) }}</th>                          


                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
