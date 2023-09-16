@extends('layouts.admin')

@section('template_title')
Bank
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            <strong>{{ __('Bank') }}s</strong>
                        </span>

                        <div class="float-right">
                            <a href="{{ route('bank.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                {{ __('Create New') }}
                            </a>
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

                                    <th>Name</th>

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banks as $bank)
                                <tr>
                                    <td>{{ ++$i }}</td>

                                    <td>{{ $bank->name }}</td>

                                    <td>
                                        <form action="{{ route('bank.destroy',$bank->id) }}" method="POST">
                                            <a class="btn btn-sm btn-danger" href="{{ route('bank.branch',['bank'=>$bank->id,'name'=>$bank->name]) }}"><i class="fa fa-fw fa-edit"></i> View Branches ({{$bank->branch->count()}})</a>
                                            <a class="btn btn-sm btn-primary " href="{{ route('bank.show',$bank->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                            <a class="btn btn-sm btn-success" href="{{ route('bank.edit',$bank->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! $banks->links() !!}
        </div>
    </div>
</div>
@endsection
