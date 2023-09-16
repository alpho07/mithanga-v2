@extends('layouts.admin')

@section('template_title')
Transaction
@endsection

@section('content')
<script>
    $(function () {

//        $("#CLIENT").bsMultiSelect({cssPatch: {
//                choices: {columnCount: '3'},
//            }});
    });
</script>


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card">

                        <div class="card-body">
                            <form id="" method="get" action="{{route('waterbill')}}">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="row ml-3 mt-3">
                                            <select value="" name="selector" id="selecOR" class="form-control">
                                                <option value="">-Select-</option>
                                                <option value="area">Service Area Accounts</option>
                                                <option value="person">Client Accounts</option>
                                                <option value="account">Single Client Account</option>
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="row ml-3 mt-3">
                                                <input type="text" class="form-control SACH"  id="SEARCH" placeholder="Search ..."/>
                                            </div>
                                            <table class="table mt-4" id="WAREA" >

                                                <tbody id="workingArea" >

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <input type="submit" value="Submit" class="btn btn-lg btn-warning"/>
                                    </div>
                                    <div class="col-4"></div>

                                </div>

                                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>

                                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">




                                        <input class="form-control mr-sm-2" id="CCID"  type="text" value="{{$cid ?? ''}}" name="cid" autofocus placeholder="Enter Client Account" aria-label="Search" style="display:none;">
                                        &nbsp;&nbsp;&nbsp;&nbsp;                                        
<!--                                        <input class="btn btn-sm btn-primary mt-2" type="submit"  value="Submit">-->

                                        <!--                                    </form>-->
                                    </div>
                                </nav>
                            </form>
                        </div>
                    </div> 

                    <div style="">



                        <div class="row pull-right">
                            <button id="PRINT" class="btn btn-sm btn-primary">Print</button>
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif



                <div class="card-body" id="printToPdf">

                    <div class="row">

                        @if(count($data2) > 0)
                        <div class="row col-md-12">


                            <style type="text/css">
                                .tg  {
                                    border-collapse:collapse;
                                    border-color:#ccc;
                                    border-spacing:0;
                                }
                                .tg td{
                                    background-color:#fff;
                                    border-color:#ccc;
                                    border-style:solid;
                                    border-width:1px;
                                    color:#333;
                                    font-family:Arial, sans-serif;
                                    font-size:14px;
                                    overflow:hidden;
                                    padding:10px 5px;
                                    word-break:normal;
                                }
                                .tg th{
                                    background-color:#f0f0f0;
                                    border-color:#ccc;
                                    border-style:solid;
                                    border-width:1px;
                                    color:#333;
                                    font-family:Arial, sans-serif;
                                    font-size:14px;
                                    font-weight:normal;
                                    overflow:hidden;
                                    padding:10px 5px;
                                    word-break:normal;
                                }
                                .tg .tg-c3ow{
                                    border-color:inherit;
                                    text-align:center;
                                    vertical-align:top
                                }
                                .tg .tg-0pky{
                                    border-color:inherit;
                                    text-align:left;
                                    vertical-align:top
                                }
                                .tg .tg-7btt{
                                    border-color:inherit;
                                    font-weight:bold;
                                    text-align:center;
                                    vertical-align:top
                                }
                                .tg .tg-dvpl{
                                    border-color:inherit;
                                    text-align:right;
                                    vertical-align:top
                                }
                                .tg .tg-fymr{
                                    border-color:inherit;
                                    font-weight:bold;
                                    text-align:left;
                                    vertical-align:top
                                }
                            </style>

                            <div class="row col-12">

                                <center>
                                    @if ($message = Session::get('error'))
                                    <div class="alert alert-danger">
                                        <p>{{ $message }}</p>
                                    </div>
                                    @endif
                                    <table class="" style="width:750px !important;">
                                        <thead>
                                            <tr>
                                                <td colspan="4"><center><strong>FINANCIAL WATER - WATER BILL</strong></center></td>
                                        </tr>
                                        <tr><td colspan="4" style="height: 10px;"></td></tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Name</strong></td>
                                                <td><strong>{{$data2[0]->account_name}}</strong></td>
                                                <td><strong>Bill Period:</strong></td>
                                                <td><strong>{{\Carbon\Carbon::parse($data2[0]->reading_date)->format('d/m/Y')}}</strong></td>

                                            </tr>
                                            <tr>
                                                <td><strong>Account No.</strong></td>
                                                <td><strong>{{$data2[0]->client_id}}</strong></td>
                                                <td><strong>Bill No.</strong> </td>
                                                <td><strong>{{$data2[0]->client_id}} - {{$data2[0]->id}}</strong></td>

                                            </tr>
                                            <tr>
                                                <td><strong>Member No.</strong></td>
                                                <td><strong>0</strong></td>
                                                <td><strong>Meter No.</strong></td>
                                                <td><strong>{{$data2[0]->client_id}}</strong></td>

                                            </tr>
                                            <tr>
                                                <td><strong>Service Area</strong></td>
                                                <td><strong>{{$data2[0]->area_name}}</strong></td>
                                                <td></td>
                                                <td></td>

                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <table class="tg">
                                        <thead>
                                            <tr>
                                                <th class="tg-7btt">BILLING DATE</th>
                                                <th class="tg-7btt">DUE DATE</th>
                                                <th class="tg-7btt">READING DATE</th>
                                                <th class="tg-7btt">PREVIOUS READING</th>
                                                <th class="tg-7btt">CURRENT READING</th>
                                                <th class="tg-7btt">CONSUMPTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td class="tg-c3ow">{{\Carbon\Carbon::parse($data2[0]->reading_date)->format('d/m/Y')}}</td>
                                                <td class="tg-c3ow">10/{{\Carbon\Carbon::parse(strtotime( "+1 month", strtotime( $data2[0]->reading_date) ))->format('m/Y')}}</td>
                                                <td class="tg-c3ow">{{\Carbon\Carbon::parse($data2[0]->reading_date)->format('d/m/Y')}}<br></td>
                                                <td class="tg-dvpl">{{$data2[0]->previous_reading}}</td>
                                                <td class="tg-dvpl">{{$data2[0]->current_reading}}</td>
                                                <td class="tg-dvpl">{{$data2[0]->consumed_units}}</td>
                                            </tr>
                                            <tr>
                                                <td class="tg-0pky" rowspan="3"></td>
                                                <td class="tg-7btt" colspan="4">CONSUMPTION DATA</td>
                                                <td class="tg-fymr">AMOUNT(In Kshs.)</td>
                                            </tr>
                                            <tr>
                                                <td class="tg-0pky" colspan="4">
                                                    <p>BALANCE BROUGHT B/F FROM PREVIOUS BILLING</p>
                                                    <p>WATER CHARGES @ {{$billing[0]->rate}} Shs. PER CUBIC METER</p>
                                                </td>
                                                <td class="tg-0pky" style="text-align: right;">
                                                    <p>{{str_replace('-','',number_format($balance[0]->balance,2))}}</p>
                                                    <p>{{$data2[0]->water_charges}}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="tg-7btt" colspan="4">AMOUNT DUE</td>
                                                <td class="tg-fymr" style="text-align: right;">{{str_replace('-','',number_format($data2[0]->balance + $data2[0]->water_charges,2))}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>

                            </div>
                            {!! $data2->appends(request()->query())->links() !!}
                            <div class=" row col-md-12">  
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <span>{{$data[0]->first_billing_message}}</span><br>
                                <span>{{$data[0]->second_billing_message}}.</span><br>
                                <span>{{$data[0]->third_billing_message}}.</span>
                            </div>
                        </div>
                        @else
                        <div class="badge badge-danger" style="font-weight: bold;font-size: 25px;">No Data found at the moment'</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>


    $(function () {

        $(document).on('keyup', "#SEARCH", function () {
            filter = new RegExp($(this).val(), 'i');
            $("#WAREA tbody tr").filter(function () {
                $(this).each(function () {
                    found = false;
                    $(this).children().each(function () {
                        content = $(this).html();
                        if (content.match(filter))
                        {
                            found = true
                        }
                    });
                    if (!found)
                    {
                        $(this).hide();
                    } else
                    {
                        $(this).show();
                    }
                });
            });
        });



        $('#selecOR').on('change', function () {
            value = $(this).val();

            if (value == 'area') {
                $.getJSON("{{route('r.area')}}", function (resp) {
                    $('#workingArea').empty();
                    $('#CCID').hide();
                    $.each(resp, function (i, d) {
                        $('#workingArea').append('<tr><td><input type=checkbox value=' + d.id + ' name="area[]"></td><td>' + d.name + '</td></tr>');
                    })
                });
            } else if (value == 'person') {
                $.getJSON("{{route('r.people')}}", function (resp) {
                    $('#workingArea').empty();
                    $('#CCID').hide();
                    $.each(resp, function (i, d) {
                        $('#workingArea').append('<tr><td><input type=checkbox value=' + d.id + ' name="people[]"></td><td>' + d.account_name + '</td></tr>');
                    })
                });
            } else if (value == 'account') {
                $('#workingArea').empty();
                $('#CCID').show();
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