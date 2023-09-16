@extends('layouts.admin')

@section('template_title')
Client
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            CUSTOMERS
                        </span>

                        <div class="float-right">
                            <a href="{{ route('client.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                Add New Customer
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
                        <table class="table table-bordered table-hover client" id="clientsTable">
                            <thead class="thead">
                                <tr>
                                    <th>Account No.</th>                                    
                                    <th>Account Name</th>
                                    <th>Area</th>
                                    <th>Phone No</th>                                  
                                    <th>Created At</th>
                                    <th>Account No.</th>
                                  
                                </tr>
                            </thead>
                            <tfoot>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>                  
                            

                            </tfoot>
                            <tbody></tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(function () {


        $('#clientsTable').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            ajax: '{!! route('get.tenants') !!}',
            columns: [
                {data: 'id', name: 'id', mRender: function (data, type, row) {
                        return "<a class='btn btn-sm btn-primary' href={{url('client/show')}}/" + row.id + ">View Account No (" + row.id + ")</a>"
                    }},

                {data: 'account_name', name: 'account_name'},
                {data: 'area_name', name: 'area_name'},
                {data: 'phone_no', name: 'phone_no'},
                {data: 'account_open_date', name: 'account_open_date'},
                {data: 'id', name: 'id'}
               
                
            ],
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var input = document.createElement("input");
                    $(input).appendTo($(column.footer()).empty())
                            .on('change', function () {
                                column.search($(this).val(), false, false, true).draw();
                            });
                });
            }
        });

    });
</script>

@endsection

