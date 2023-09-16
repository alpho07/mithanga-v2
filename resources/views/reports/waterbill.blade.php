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

<!--form method="post" action="{{route('waterbill')}}">
                                    @csrf
                                    <select  id="selecOR" class="form-control" name="selected" >
                                        <option value="area">Service Area Account(s)</option>
                                        <option value="person">Client(s) Account(s)</option>
                                        <option value="account">Single Account</option>
                                    </select>

                                    <span id="AREA" >
                                        <select class="form-input mt-2" name="area[]" style="width:200px !important; " multiple>
                                            @foreach($areas as $b)
                                            <option value="{{$b->id}}">{{$b->name}}</option>
                                            @endforeach                            
                                        </select> &nbsp;&nbsp;&nbsp;&nbsp;
                                    </span>
                                    <span id="CLIENT"  style="display:none !important;">
                                        <select   class="form-input mt-2" name="client[]"  multiple>
                                            @foreach($clients as $a)
                                            <option value="{{$a->id}}">{{$a->account_name}}</option>
                                            @endforeach                            
                                        </select> 
                                    </span>

                                    <input class="form-control mr-sm-2  mt-2" id="CCID" style="display:none;" type="text" value="{{$cid ?? ''}}" name="account" autofocus placeholder="Enter Client Account" aria-label="Search">
                                    &nbsp;&nbsp;&nbsp;&nbsp;                                        
                                    <input class="btn btn-sm btn-primary mt-3" type="submit"  value="Submit">

                                </form-->


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

                                        <!--                                    <form method="get" action="{{route('waterbilla')}}">-->
                                        <!--select class="form-input" name="client" id="CLIENT" style="display:none;">
                                            <option value="">-Select Client-</option>
                                            @foreach($clients as $a)
                                            <option value="{{$a->id}}">{{$a->account_name}}</option>
                                            @endforeach                            
                                        </select> &nbsp;&nbsp;&nbsp;&nbsp;
                                        <div id="AREA2" style="display:none;" >
                                            <select class="form-input" name="" style="width:200px !important; " id="AREA">
                                                <option value="">-Select Area-</option>
                                                @foreach($areas as $a)
                                                <option value="{{$a->id}}">{{$a->name}}</option>
                                                @endforeach                            
                                            </select> &nbsp;&nbsp;&nbsp;&nbsp;
                                        </div-->


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




                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif




            </div>
        </div>
    </div>
</div>


<script>


    $(function () {
        
        $('.SACH').hide();

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
                    $('.SACH').show();
                    $.each(resp, function (i, d) {
                        $('#workingArea').append('<tr><td><input type=checkbox value=' + d.id + ' name="area[]"></td><td>' + d.name + '</td></tr>');
                    })
                });
            } else if (value == 'person') {
                $.getJSON("{{route('r.people')}}", function (resp) {
                    $('#workingArea').empty();
                    $('#CCID').hide();
                    $('.SACH').show();
                    $.each(resp, function (i, d) {
                        $('#workingArea').append('<tr><td><input type=checkbox value=' + d.id + ' name="people[]"></td><td>' + d.account_name + '</td></tr>');
                    })
                });
            } else if (value == 'account') {
                $('#workingArea').empty();
                $('#CCID').show();
                $('.SACH').hide();
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