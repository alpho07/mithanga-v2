@extends('layouts.admin')

@section('template_title')
Transaction
@endsection

@section('content')
<style>
    body {
        background-color: #000
    }

    .padding {
        padding: 2rem !important
    }

    .card {
        margin-bottom: 30px;
        border: none;
        -webkit-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
        -moz-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);
        box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22)
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #e6e6f2
    }

    h3 {
        font-size: 20px
    }

    h5 {
        font-size: 15px;
        line-height: 26px;
        color: #3d405c;
        margin: 0px 0px 15px 0px;
        font-family: 'Circular Std Medium'
    }

    .text-dark {
        color: #3d405c !important
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            <strong>INVOICE #{{$ref}}</strong>
                        </span>

                        <div class="float-right">
                            <a href="{{ route('payment.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                <i class="fa fa-print" aria-hidden="true"></i> Print
                            </a>
                            <a href="{{ route('payment.adjust') }}" class="btn btn-warning btn-sm float-right"  data-placement="left">
                                <i class="fa fa-pencil" aria-hidden="true"></i> Edit
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
                    <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
                        <div class="card">
                            <div class="card-header p-4">
                                <a class="pt-2 d-inline-block" href="index.html" data-abc="true">FINANCIAL WATER SERVICES</a>
                                <div class="float-right">
                                    <h3 class="mb-0">Invoice #{{$ref}}</h3>
                                    Date: {{$invoice[0]->date}}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-sm-6">
                                        <h5 class="mb-3">From:</h5>
                                        <h3 class="text-dark mb-1">FINANCAL WATER SERVICES</h3>
                                        <div>P.O. Box 10000</div>
                                        <div>a,b</div>
                                        <div>Email: financial@gmail.com</div>
                                        <div>Phone:0700000000000000000000</div>
                                    </div>
                                    <div class="col-sm-6 ">
                                        <h5 class="mb-3">To:</h5>
                                        <h3 class="text-dark mb-1">{{$supplier[0]->name}}</h3>                                      
                                        <div>Email: </div>
                                        <div>Phone: {{$supplier[0]->phone}}</div>
                                    </div>
                                </div>
                                <div class="table-responsive-sm">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="center">#</th>
                                                <th>Item</th>
                                                <th></th>
                                                <th class="right"></th>
                                                <th class="center"></th>
                                                <th class="right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($details as $d)
                                            <tr>
                                                <td class="center">{{++$i}}</td>
                                                <td class="left strong">{{$d->center}}</td>
                                                <td class="left"></td>
                                                <td class="right"></td>
                                                <td class="center"></td>
                                                <td style="text-align: right;">{{number_format($d->amount,2)}}</td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-sm-5">
                                    </div>
                                    <div class="col-lg-4 col-sm-5 ml-auto">
                                        <table class="table table-clear">
                                            <tbody>

                                                <tr>
                                                    <td class="left">
                                                        <strong class="text-dark">Total</strong> </td>
                                                    <td class="right">
                                                        <strong class="text-dark">{{number_format($invoice[0]->amount_invoiced,2)}}</strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <p class="mb-0"> {{trans('panel.site_title')}}</p>
                            </div>
                        </div>
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
                    FINANCIAL WATER SERVICES<br>
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
