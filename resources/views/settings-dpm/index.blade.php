@extends('layouts.admin')

@section('template_title')
Settings Dpm
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            <strong>SETTINGS | DATE / PERIOD / MESSAGES</strong>
                        </span>

                        <div class="float-right">
<!--                            <a href="{{ route('settings_dpm.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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

                                    <th>Billing Period</th>
                                    <th>Due Days</th>
                                    <th>First Billing Message</th>
                                    <th>Second Billing Message</th>
                                    <th>Third Billing Message</th>
                                    <th>Receipt Message</th>

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($settingsDpms as $settingsDpm)
                                <tr>
                                    <td>{{ ++$i }}</td>

                                    <td>{{ $settingsDpm->billing_period }}</td>
                                    <td>{{ $settingsDpm->due_days }}</td>
                                    <td>{{ $settingsDpm->first_billing_message }}</td>
                                    <td>{{ $settingsDpm->second_billing_message }}</td>
                                    <td>{{ $settingsDpm->third_billing_message }}</td>
                                    <td>{{ $settingsDpm->receipt_message }}</td>

                                    <td>
                                        <form action="{{ route('settings_dpm.destroy',$settingsDpm->id) }}" method="POST">
                                            <a class="btn btn-sm btn-primary " href="{{ route('settings_dpm.show',$settingsDpm->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                            <a class="btn btn-sm btn-success" href="{{ route('settings_dpm.edit',$settingsDpm->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
            {!! $settingsDpms->links() !!}
        </div>
    </div>
</div>
@endsection
