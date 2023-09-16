@extends('layouts.admin')

@section('template_title')
Transaction
@endsection

@section('content')
<style>

    table td {
        border: 1px solid black;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            <strong>STATEMENT OF ACCOUNT</strong>
                        </span>

                        <div class="float-right">

                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif


                <div class="table-responsive">
                    <form action="{{ route('statement.get') }}" method="POST">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="thead">
                                <tr>
                                    <th>Client/Area</th>
                                    <th>Date From</th>
                                    <th>Date To</th>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>

                                    <td>
                                        <select name="client_id" id='SCLIENTID' class="form-control select2" >

                                            @foreach($clients as $id => $client)
                                            <option {{$client_id=='$client->id' ?'selected':''}} value="{{ $client->id }}">{{'ACCOUNT No. '.$client->id. ' | '.$client->account_name.' | '.$client->area_name  }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <input type="text" name="from" value="{{$from}}" placeholder="From" class="form-control "/>
                                    </td>
                                    <td>
                                        <input type="text" name="to" value="{{$to}}" placeholder="To" class="form-control datepicker"/>
                                    </td>

                                    <td>

                                        @can('billing_access')
                                        <button type="input" class="btn btn-sm btn-success" ><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> Get Statement</button>
                                        @endcan
                                        @csrf

                                        </form>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                </div>
                <section id="printToPdf">
                    <div class="row col-12">
                        <div class="row col-12">
                            <div class="d-flex justify-content-end mb-4">
                                <form action="{{ url('statement/print') }}" method="get">
                                    @csrf
                                    <button class="btn btn-primary" type="button" id="PRINT">PRINT</button>
                                    <!--                                    <button class="btn btn-primary" type="submit" >Export to PDF</button>-->
                                </form>
                            </div>
                        </div>


                    </div>


                    <div class="table-responsive">
                        <table class="table table-bordered table-bordered">
                            <thead class="thead">
                                <tr>
                                    <td><strong>Name</strong></td>
                                    <td><strong>{{strtoupper($clients_narrowed[0]->account_name)}}</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>Service Area</strong></td>
                                    <td><strong>{{strtoupper($clients_narrowed[0]->area_name)}}</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Account No:</strong></td>
                                    <td><strong>{{strtoupper($clients_narrowed[0]->id)}}</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>Statement Period</strong></td>
                                    <td><strong>{{date('M Y', strtotime($from))}} to {{date('M Y', strtotime($to))}}</strong></td>
                                </tr>
                                <tr>
                                    <th>DATE</th>
                                    <th>DESCRIPTION</th>
                                    <th>UNITS AND READINGS</th>
                                    <th>REFERENCE</th>
                                    <th style="text-align: right;">DEBIT</th>
                                    <th style="text-align: right;">CREDIT</th>
                                    <th style="text-align: right;">BALANCE</th>
                                </tr>
                                <tr>
                                    <td colspan="6" style="font-weight: bold;">{{$opening_balance >= 0 ? 'OPENING BALANCE' : 'ARREARS'}}</td>
                                    @php $balan2  = ($opening_balance < 0) ? '('.number_format($opening_balance,2).')' : number_format($opening_balance,2) @endphp
                                    <td style="text-align: right;"><b>{{str_replace('-','',$balan2)}}</b></td>
                                </tr>
                            </thead>
                            <tbody>

                                @php 
                                $account_balance = $opening_balance; 
                                @endphp
                                @foreach($statement as $s)
                                @php
                                $account_balance = ($s->type =='credit') ? $account_balance - $s->amount : $account_balance + $s->amount;
                                $credit_amount= ($s->type =='credit') ? $s->amount : '';
                                $debit_amount= ($s->type =='debit') ? $s->amount : '';                           

                                @endphp

                                <tr>
                                    <td>{{\Carbon\Carbon::parse($s->transaction_date)->format('d/m/Y')}}</td>                                                                    
                                    <td>
                                        @php
                                        if(strpos( $s->description,'CASH') !== false || strpos( $s->description,'M-PESA') !== false){
                                        echo "RECEIPTS";
                                        } else{
                                        echo strtoupper($s->description);
                                        }
                                        @endphp


                                    </td>  
                                    <td>
                                        @if (strpos(strtolower($s->description), 'water') !== false) 
                                        {{$s->units.'(C) - '.$s->last_read.'(R)'}}                                        
                                        @endif
                                        @if (strpos(strtolower($s->description), 'disconnection') !== false) 
                                        {{$s->units.'(C) - '.$s->last_read.'(R)'}}                                        
                                        @endif
                                    </td>
                                    <td>
                                        @if(\is_null($s->mode))
                                        @if (strpos(strtolower($s->description), 'disconnection') !== false) 
                                        {{$s->reference}}
                                        @elseif(strpos(strtolower($s->description), 'reconnection') !== false)
                                        {{$s->reference}}
                                        @else
                                        {{$s->reference}}
                                        @endif

                                        @else

                                        @if (strpos(strtolower($s->description), 'reconnection') !== false) 
                                        {{$s->reference}}
                                        @else
                                        {{$s->m_reference}}
                                        @endif
                                        @endif
                                    </td>
                                    <td style="text-align: right;">{{is_numeric($debit_amount) ? number_format($debit_amount,2) : $debit_amount}}</td>
                                    <td style="text-align: right;">{{is_numeric($credit_amount) ? number_format($credit_amount,2) : $credit_amount}}</td>
                                    <td style="text-align: right;">{{str_replace('-','',number_format($account_balance,2))}}</td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    @php $balan  = ($account_balance < 0) ? '('.number_format($account_balance,2).')' : number_format($account_balance,2) @endphp
                                    <td colspan="6" style="font-weight: bold;">CLOSING BALANCE</td>                              
                                    <td style="text-align: right;"><b>{{str_replace('-','',$balan) }}</b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </section>

            </div>
        </div>
    </div>



</div>


<script>
    $(function () {
        $('#SCLIENTID').select2();
        $('#SCLIENTID').val("{{$client_id}}").trigger('change');



        function printData()
        {
            $('table th').css('border', '1px solid black')
            $('table th').css('padding', '3px`')
            $('table td').css('border', '1px solid black')
            $('table td').css('padding', '3px')
            $('table').css('border-collapse', 'collapse')
            var divToPrint = document.getElementById("printToPdf");
            newWin = window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }

        $('#PRINT').on('click', function () {
            printData();
        })

    })
</script>
@endsection
