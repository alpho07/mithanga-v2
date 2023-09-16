@extends('layouts.admin')

@section('template_title')
Branch
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            <strong><a href="{{route('bank.index')}}" title="Back to Banks"> <i class="fa fa-chevron-left" aria-hidden="true"></i>  </a> {{$name}}'s {{ __('Branch') }}es</strong>
                        </span>

                        <div class="float-right">
                            <a href="{{ route('branch.create',['bank'=>$bank,'name'=>$name]) }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                @foreach ($branches as $branch)
                                <tr>
                                    <td>{{ ++$i }}</td>

                                    <td>{{ $branch->name }}</td>                                   

                                    <td>
                                        <form action="{{ route('branch.destroy',['id'=>$branch->id,'bank'=>$bank,'name'=>$name]) }}" method="POST">
                                            <a class="btn btn-sm btn-success" href="{{ route('branch.edit',['id'=>$branch->id,'bank'=>$bank,'name'=>$name]) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
          
        </div>
    </div>
</div>
@endsection
