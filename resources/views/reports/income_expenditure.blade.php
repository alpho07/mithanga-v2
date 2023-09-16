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
                            <strong>FINANCIAL WATER - ACCOUNT</strong>
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
                    <form action="{{ route('income.expenditure') }}" method="get">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="thead">
                                <tr>                                   
                                    <th>Date From</th>
                                    <th>Date To</th>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>


                                    <td>
                                        <input type="text" name="from" value="{{$from}}" placeholder="From" class="form-control datepicker"/>
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
                                <form action="{{ url('income.expenditure') }}" method="get">
                                    @csrf
                                    <button class="btn btn-primary" type="button" id="PRINT">PRINT</button>
                                    <!--                                    <button class="btn btn-primary" type="submit" >Export to PDF</button>-->
                                </form>
                            </div>
                        </div>


                    </div>


                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr><td colspan="4"><strong>INCOME EXPENDITURE BETWEEN {{\Carbon\Carbon::parse($from)->format('d/m/Y')}} AND {{\Carbon\Carbon::parse($to)->format('d/m/Y')}}</strong> </td></tr>
                            <tr>
                                <td colspan="3"><strong>INCOME</strong></td>
                                <td style="text-align: center;"><strong>KSHS.</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3">ARREARS</td>
                                <td style="text-align: right;">{{number_format(@$arrears[0]->amount,2)}}</td>
                            </tr>
                            <tr>
                                <td colspan="3">APPLICATION FEE</td>
                                <td style="text-align: right;">{{number_format(@$application[0]->amount,2)}}</td>
                            </tr>
                            <tr>
                                <td colspan="3">WATER CHARGES</td>
                                <td style="text-align: right;">{{number_format(@$water_charges[0]->amount,2)}}</td>
                            </tr>
                            <tr>
                                <td colspan="3">DEBIT ADJUSTMENTS</td>
                                <td style="text-align: right;">{{number_format(@$adjustments[0]->amount,2)}}</td>
                            </tr>
                            <tr>
                                <td colspan="3">MISCALLENEOUS</td>
                                <td style="text-align: right;">{{number_format(@$miscallenous[0]->amount,2)}}</td>
                            </tr>
                            <tr>
                                <td colspan="3"><strong>TOTAL INCOME</strong></td>
                                @php    
                                $total_inc = @$arrears[0]->amount + @$application[0]->amount + @$water_charges[0]->amount + @$adjustments[0]->amount + @$miscallenous[0]->amount;
                                @endphp
                                <td style="text-align: right;"><strong>{{number_format($total_inc,2)}}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td colspan="3"><strong>EXPENDITRUE</strong></td>
                                <td><strong>KSHS</strong></td>
                            </tr>
                            @php 
                            $exenditure = 0;
                            @endphp
                            @foreach($expenses as $e) 
                            <tr>
                                @php
                                $exenditure =  $exenditure + $e->amount;
                                @endphp
                                <td colspan="3">{{strtoupper($e->name)}}</td>
                                <td style="text-align: right;">{{number_format($e->amount,2)}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="3"><strong>TOTAL EXPENDITRUE</strong></td>
                                <td style="text-align: right;"><strong>{{number_format($exenditure,2)}}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"><strong>EXCESS OF INCOME OVER EXPENDITRUE</strong></td>
                                <td style="text-align: right;"><strong>{{number_format($total_inc - $exenditure,2)}}</strong></td>
                            </tr>

                        </table>
                    </div>
                </section>

            </div>
        </div>
    </div>



</div>


<script>
    $(function () {



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
