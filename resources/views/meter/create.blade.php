@extends('layouts.admin')

@section('template_title')
Create Transaction
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Meter Changing</span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('meter.change.post')}}" id="TFORM" role="form" enctype="multipart/form-data">
                        @csrf

                        @include('meter.form')

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function () {
        $('select').select2();

        $('#suMit').click(function () {
            val1 = parseInt($('#NewPReading').val());
            val2 = parseInt($('#PREREADING').text());

            if ($('#client_id').val() == '') {
                Swal.fire(
                        'Client Required',
                        '',
                        'error'
                        );
                return false;
            } else if ($('#DateS').val() == '') {
                Swal.fire(
                        'Change Date Required',
                        '',
                        'error'
                        );
                return false;
            } else if ($('#NewPReading').val() == '') {
                Swal.fire(
                        'New Reading Required',
                        '',
                        'error'
                        );
                return false;
            } else {

                if ($('#PREREADING').val() === 'No Previous Readings found') {
                    Swal.fire(
                            'Notice',
                            'Previous reading could not be found. New changed saved',
                            'success'
                            );
                    $('#TFORM').submit();
                } /*else if (val2 > val1) {
                    Swal.fire(
                            'Invalid Entry',
                            'You cannot change meter readings and have the meter changed reading as less than the previous one!',
                            'error'
                            );
                    return false;
                }*/ else {
                    Swal.fire(
                            'Success',
                            'Meter Changes saved successfully!',
                            'success'
                            );
                    $('#TFORM').submit();
                }
            }
        });

        $('#client_id').change(function () {
            value = $(this).val();
            $.getJSON("{{url('lastRead')}}/" + value, function (v) {
                //if(v[0].current_reading)
                $('#PREREADING').text(v[0].current_reading);
            });
        });
    })
</script>
@endsection
