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
                        <span class="card-title">Create New Bill</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('bill.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('transaction.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script>
    $(function(){
      $('#client_id').select2(); 
    });
</script>
@endsection
