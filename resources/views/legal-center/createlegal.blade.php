@extends('layouts.admin')

@section('template_title')
Create Transaction
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-6">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Legal Center</span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('legal.save')}}"  role="form" enctype="multipart/form-data">
                       

                        @include('legal-center.formlegal')

                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
<script>
    $(function () {
        $('#client_id').change(function () {
            id = $(this).val();
            $.getJSON("{{url('client-last-info')}}/" + id, function (res) {
                $('#account_name').html(' <strong>' + res[0].account_name + '</strong>');
                $('#account_reading').html(' <strong>' + res[0].current_reading + '</strong>');
                $('#account_balance').html(' <strong>' + res[0].balance + '<strog>');
            });
        });
    })
</script>
@endsection
