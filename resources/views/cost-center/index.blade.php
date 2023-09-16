@extends('layouts.admin')
@section('template_title')
Cost Center
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            {{ __('Cost Center') }}
                        </span>

                        <div class="float-right">
                            <a href="{{ route('cost-centers.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                        <table class="table table-striped table-hover costcener">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>

                                    <th>Center</th>

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($costCenters as $costCenter)
                                <tr>
                                    <td>{{ ++$i }}</td>

                                    <td>{{ $costCenter->center }}</td>

                                    <td>
                                        <form action="{{ route('cost-centers.destroy',$costCenter->id) }}" method="POST">
                                            <a class="btn btn-sm btn-primary " href="{{ route('cost-centers.show',$costCenter->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                            <a class="btn btn-sm btn-success" href="{{ route('cost-centers.edit',$costCenter->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
            {!! $costCenters->links() !!}
        </div>
    </div>
</div>
@endsection
