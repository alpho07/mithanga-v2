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
                    @include('reports.menu')
                </div>                    
            </div>
        </div>
    </div>
</div>



<script>
    $(function () {

      


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