@extends('layouts.admin')

@section('template_title')
Settings Nbrd
@endsection

@section('content')
<style>
    .btn-sm{
        margin: 1px;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            <strong>SETTINGS | NAME / BILLING RATES / DISCOUNT</strong>
                        </span>

                        <div class="float-right">
                            <!--                            <a href="{{ route('settings_nbrd.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                                            {{ __('Create New') }}
                                                        </a>-->
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>

                                    <th>Company Name</th>
                                    <th>Company Name Short</th>
                                    <th>Billing Rate Per Cubic M(Ksh.)</th>
                                    <th>Discount Rate(%)</th>
                                    <th>Reconnection Fee(Ksh.)</th>
                                    <th>Bank Name</th>
                                    <th>Branch</th>
                                    <th>Account Number(#)</th>

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($settingsNbrds as $settingsNbrd)
                                <tr>
                                    <td>{{ ++$i }}</td>

                                    <td>{{ $settingsNbrd->company_name }}</td>
                                    <td>{{ $settingsNbrd->company_name_short }}</td>
                                    <td>{{ $settingsNbrd->billing_rate_per_cubic_m }}</td>
                                    <td>{{ $settingsNbrd->discount_rate }}</td>
                                    <td>{{ $settingsNbrd->reconnection_fee }}</td>
                                    <td>{{ $settingsNbrd->bank_name }}</td>
                                    <td>{{ $settingsNbrd->branch }}</td>
                                    <td>{{ $settingsNbrd->account_number }}</td>

                                    <td>
                                        <form action="{{ route('settings_nbrd.destroy',$settingsNbrd->id) }}" method="POST">
                                            <a class="btn btn-sm btn-primary " href="{{ route('settings_nbrd.show',$settingsNbrd->id) }}" title="Show"><i class="fa fa-fw fa-eye"></i></a>
                                            <a class="btn btn-sm btn-success" href="{{ route('settings_nbrd.edit',$settingsNbrd->id) }}" title="Edit"><i class="fa fa-fw fa-edit"></i></a>
                                            @csrf
                                            @method('DELETE')
<!--                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>-->
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! $settingsNbrds->links() !!}
        </div>
    </div>
</div>
@endsection
