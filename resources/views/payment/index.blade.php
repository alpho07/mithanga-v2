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
                            <strong>Payments</strong>
                        </span>

                        <div class="float-right">
                            <a href="{{ route('payment.adjust') }}" class="btn btn-warning btn-sm float-right"  data-placement="left">
                                <i class="fa fa-plus" aria-hidden="true"></i> Tansaction Adjustments
                            </a>
                            <a href="{{ route('payment.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                <i class="fa fa-plus" aria-hidden="true"></i> Make New Payment
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
                    <!--                    <a href="{{ route('run.bill') }}" class="btn btn-warning btn-lg float-left"  data-placement="left">
                                            Run Bills <i class="fa fa-rocket" aria-hidden="true"></i>
                                        </a>-->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Account No.</th>
                                    <th>Client</th>
                                    <th>Description</th>
                                    <th>Date</th>
<!--                                    <th>Amount Received</th>-->
                                    <th>Amount Paid</th>
                                    <th>Reference</th>
                                    <th>Served By</th>
                                    <th>bank</th>
                                    <th>Mode</th>

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ ++$i}}</td>
                                    <td>{{ $transaction->client_id }}</td>
                                    <td>{{ $transaction->account_name }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ $transaction->date }}</td>
<!--                                    <td style="text-align: right;">{{ number_format($transaction->amount_received,2) }}</td>-->
                                    <td style="text-align: right;">{{ number_format($transaction->amount,2) }}</td>
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ $transaction->staff }}</td>
                                    <td>{{ $transaction->bank.' - ' .$transaction->branch}}</td>
                                    <td>{{ $transaction->mode }}</td>
                                    <td>
                                        <form action="{{ route('bill.destroy',$transaction->id) }}" method="POST">
                                            @can('billing_access')
                                            <a class="btn btn-sm btn-success" data-pid="{{$transaction->id}}" data-client-id="{{$transaction->client_id}}" href="{{url('client-info-receipt').'/'.$transaction->id.'/'.$transaction->client_id}}"  id="TRANSRCEIPT"><i class="fa fa-print" aria-hidden="true"></i> View & Print</a>
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

<!-- Modal -->
<div id="Receipt" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <style>
                    body {
                        margin: 0;
                        padding: 0;
                        font-family: 'PT Sans', sans-serif;
                    }

                    @page {
                        size: 2.8in 11in;
                        margin-top: 0cm;
                        margin-left: 0cm;
                        margin-right: 0cm;
                    }

                    table {
                        width: 100%;
                    }

                    tr {
                        width: 100%;

                    }

                    h1 {
                        text-align: center;
                        vertical-align: middle;
                    }

                    #logo {

                        text-align: center;
                        -webkit-align-content: center;
                        align-content: center;
                        padding: 5px;
                        margin: 2px;
                        display: block;
                        margin: 0 auto;
                    }

                    header {
                        width: 100%;
                        text-align: center;
                        -webkit-align-content: center;
                        align-content: center;
                        vertical-align: middle;
                    }

                    .items thead {
                        text-align: center;
                    }

                    .center-align {
                        text-align: center;
                    }

                    .bill-details td {
                        font-size: 12px;
                    }

                    .receipt {
                        font-size: medium;
                    }

                    .items .heading {
                        font-size: 12.5px;
                        text-transform: uppercase;
                        border-top:1px solid black;
                        margin-bottom: 4px;
                        border-bottom: 1px solid black;
                        vertical-align: middle;
                    }

                    .items thead tr th:first-child,
                    .items tbody tr td:first-child {
                        width: 47%;
                        min-width: 47%;
                        max-width: 47%;
                        word-break: break-all;
                        text-align: left;
                    }

                    .items td {
                        font-size: 12px;
                        text-align: right;
                        vertical-align: bottom;
                    }

                    .price::before {
                        content: "\20B9";
                        font-family: Arial;
                        text-align: right;
                    }

                    .sum-up {
                        text-align: right !important;
                    }
                    .total {
                        font-size: 13px;
                        border-top:1px dashed black !important;
                        border-bottom:1px dashed black !important;
                    }
                    .total.text, .total.price {
                        text-align: right;
                    }
                    .total.price::before {
                        content: "\20B9"; 
                    }
                    .line {
                        border-top:1px solid black !important;
                    }
                    .heading.rate {
                        width: 20%;
                    }
                    .heading.amount {
                        width: 25%;
                    }
                    .heading.qty {
                        width: 5%
                    }
                    p {
                        padding: 1px;
                        margin: 0;
                    }
                    section, footer {
                        font-size: 12px;
                    }

                    @media print {
                        .modal {
                            position: absolute;
                            left: 0;
                            top: 0;
                            margin: 0;
                            padding: 0;
                            overflow: visible!important;
                        }
                    }
                </style>
                </head>

                <body>

                    <p style="font-weight: bold;">
                <center>
                    FIANANCIAL WATER SERVICES<br>
                    <small>P.O.Box 0000<br>Tel:0071771<br>Email:financial@gmail.com</small>
                </center></p>
                <table class="bill-details" style="margin-top: 10px;">
                    <tbody>
                        <tr>
                            <td><strong>Date :</strong> <span id="pdate">1</span></td>
                        </tr>
                        <tr>
                            <td><strong>Receipt No. : </strong><span id="pref">2</span></td>
                        </tr>
                        <tr>
                            <td><strong>Account No #:</strong> <span id="paccount">3</span></td>
                        </tr>
                        <tr>
                            <td><strong>Account Name : </strong><span id="paname">4</span></td>
                        </tr>
                        <tr>
                            <th class="center-align" colspan="2"><span class="receipt">Original Receipt</span></th>
                        </tr>
                    </tbody>
                </table>

                <table class="items">
                    <thead>
                        <tr>
                            <th class="heading name">Item</th>
                            <th class="heading qty"></th>
                            <th class="heading rate"></th>
                            <th class="heading amount">Amount(Ksh.)</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td id="pitem"></td>
                            <td></td>
                            <td class=""></td>
                            <td id="price_"></td>
                        </tr>
                        <tr>
                            <td>Amount Due</td>
                            <td></td>
                            <td class=""></td>
                            <td id="price_due"></td>
                        </tr>

                    </tbody>
                </table>
                <section>
                    <p style="margin-top: 10px;">
                        Mode of payment : <span id="mode">CASH</span>  
                    </p>
                    <p style="margin-top: 2px;">
                        Served by: <span id="served">JAMILA</span>
                    </p>
                    <hr>
                    <p style="margin-top: 10px;">
                        Our PAYBILL NO: 823496 for M-PESA payments
                    </p>
                    <p style="margin-top: 2px;">
                        <small>Disconnection For Non-Payment: 10th of every month</small>
                    </p>
                    <p style="margin-top: 2px;">
                        <small>Reconnection Charges: Ksh. 1,155.00</small>
                    </p>
                </section>
                <footer style="text-align:center">
                    <p> <small>We thank you for giving us the opportunity to serve you!</small></p>
                    <div class="row col-md-12" style="height: 70px;">

                    </div>

                </footer>
                <p style="margin-top: 2px;">
                    <small>Official Stamp.......................................<br>
                        CUSTOMER COPY</small>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="js:window.print()"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                <button type="button" class="btn btn-danger"  data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i> Cancel</button>
            </div>
        </div>

    </div>
</div>
@endsection
