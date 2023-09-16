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
                    <span class="card-title">Make New Payment Adjustments</span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('payment.save.adjustment') }}"  role="form" enctype="multipart/form-data">
                        @csrf

                        @include('payment.form_adj')

                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title"><b>Client Details</b></span>
                </div>
                <div class="card-body">
                    <table class="table-bordered table-responsive">
                        <tr>
                            <td>Account Name</td>
                            <td><span id="account_name"></span></td>
                        </tr>
<!--                        <tr>
                            <td>Current Reading:</td>
                            <td><span id="account_reading"></span></td>
                        </tr>-->
                        <tr>
                            <td>Arrears</td>
                            <td><span id="account_balance"></span></td>
                        </tr>
                    </table>                
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function () {
        $('#client_id').select2();
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
