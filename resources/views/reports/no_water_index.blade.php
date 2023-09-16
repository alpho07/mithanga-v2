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
                    <div class="card">

                        <div class="card-body">
                            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

                                    <form method="post" action="{{route('no.water.debits.post')}}">
                                        @csrf
                                        <table>
                                            <tr>
                                                <td>
                                                    <select class="" name="area[]" style="width:200px;" id="AREA" multiple="multiple">
                                                        @foreach($area2 as $a)
                                                        <option value="{{$a->id}}">{{$a->name}}</option>
                                                        @endforeach

                                                    </select> 
                                                </td>
                                                <td>
                                                    <input type="submit" class="btn btn-sm btn-primary" value="Submit"/>
                                                </td>
                                            </tr>
                                        </table>



                                    </form>
                                </div>
                            </nav>
                        </div>
                    </div> 

                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(function () {

        $('select').val("{{@$final}}").change();


        $('select').select2({
            placeholder: "Select Area",
            allowClear: true
        });





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