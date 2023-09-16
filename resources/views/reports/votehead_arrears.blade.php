@extends('layouts.admin')

@section('template_title')
Transaction
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                @include('reports.menu')
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif





                <div class="card-body" id="printToPdf">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-5">
                            <center><strong><b>FINANCIAL WATER <br>  {{@$pe}}</b></strong></center>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">           
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="tg-7btt">ACCOUNT No.</th>
                                        <th class="tg-7btt">CLIENT NAME</th>
                                        <th class="tg-7btt">AREA</th>
                                        <th class="tg-7btt">AMOUNT</th>
                                        <th class="tg-7btt">BALANCE</th>
                                        <th class="">DATE</th>                                                                                  
                                        <th class="">REF. NO.</th>                                                                                  
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $TOT=0 @endphp
                                    @if(count($result)>0)
                                    @foreach($result as $r)
                                    @php $TOT = $TOT +  $r->balance * -1 @endphp
                                    <tr>
                                        <td>{{$r->client_id}}</td>                                      
                                        <td>{{$r->account_name}}</td>                                      
                                        <td>{{$r->area_name}}</td>                                      
                                        <td style="text-align: right;">{{number_format($r->amount,2)}}</td>                                      
                                        <td style="text-align: right;">{{number_format($r->balance,2)}}</td>                                     
                                        <td>{{\Carbon\Carbon::parse($r->date)->format('d/m/Y')}}</td>
                                        <td>{{$r->reference}}</td>   

                                    </tr>
                                    @endforeach

                                    @else                                 
                                    <tr>
                                        <td colspan="7"><div class="alert-danger">No Data for this period</div></td>                                       
                                    </tr>
                                    @endif

                                <tfoot>
                                    <tr>
                                        <th class=""></th>
                                        <th class=""></th>
                                        <th class="">GRAND TOTAL</th>                                     
                                        <th class="" ></th> 
                                        <th class="tg-7btt" style="text-align: right; font-size: 20px;"> {{number_format($TOT,2)}}</th> 
                                        <th class=""></th>
                                        <th class=""></th>
                                    </tr>
                                </tfoot>

                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<script>
    $(function () {

        $('#SCLIENTID').val("{{@$client_id}}").trigger('change');


        $('.radio').change(function () {
            value = $(this).val();
            if (value == 'receipt') {
                $('#receiptno').show();
            } else {
                $('#receiptno').hide();
            }
            if (value == 'votehead') {
                $('#VH').show();
            } else {
                $('#VH').hide();
            }
        })

        $('#DateSel').change(function () {
            value = $(this).val();
            if (value == 'datesingle') {
                $('#d1').show();
                $('.d2').hide();
            } else {
                $('#d1').hide();
                $('.d2').show();
            }
        })



        function printData()
        {
            $('.pagination').hide();
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