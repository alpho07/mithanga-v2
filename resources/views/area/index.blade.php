@extends('layouts.admin')

@section('template_title')
    Zones
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Zones
                            </span>

                            <div class="float-right">
                                <a href="{{ route('areas.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
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
                        <div class="table-responsive1 ">
                            <table class="table table-striped table-hover areas" id="ZonesData">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Rate</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($areas as $area)
                                        <tr>
                                            <td>{{ ++$i }}</td>

                                            <td>{{ $area->name }}</td>
                                            <td>{{ $area->rate }}</td>

                                            <td>
                                                <form action="{{ route('areas.destroy', $area->id) }}" method="POST"
                                                    id="DELETE">
                                                    <a class="btn btn-sm btn-primary "
                                                        href="{{ route('reading.sheet', $area->id) }}"><i
                                                            class="fa fa-fw fa-eye"></i> View Clients
                                                        ({{ $area->client->count() }})
                                                    </a>
                                                    <a class="btn btn-sm btn-warning "
                                                        href="{{ route('clients.print', $area->id) }}"><i
                                                            class="fa fa-fw fa-print"></i> Print Clients</a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('areas.edit', $area->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm deleteButton"
                                                        id="deleteButton"><i class="fa fa-fw fa-trash"></i> Delete</button>
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
    <script>
        $(document).ready(function() {


            // Event handler for '#deleteButton'
            $(document).on('click', '#deleteButton', function(event) {
                // Prevent the default form submission
                event.preventDefault();

                // Show the confirmation alert
                var confirmDelete = confirm("You are about to delete this record, Continue?");

                // If the user clicks "OK" in the alert, proceed with the delete action
                if (confirmDelete) {
                    // Submit the form with ID "DELETE" to perform the delete action
                    $('#DELETE').submit();

                    // Add your code here to handle the delete action
                    // For example, you can make an AJAX request to delete the record
                    // ...

                    // For this example, we'll just display a success message after a short delay
                    setTimeout(function() {
                        alert("Record deleted successfully!");
                    }, 500); // Wait 500 milliseconds (0.5 seconds) before showing the success message
                } else {
                    // User clicked "Cancel" in the confirmation dialog, so do nothing
                    return false;
                }
            });

            $(document).ready(function() {
                $('#ZonesData').DataTable({
                    responsive: true
                });
            });
        })
    </script>
@endsection
