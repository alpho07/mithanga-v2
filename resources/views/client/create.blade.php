@extends('layouts.admin')

@section('template_title')
    Create Customer
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">New Customer</span>

                    </div>
                    <div class="card-body" style="background: #fff">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif


                        <form method="POST" action="{{ route('client.store') }}" role="form"
                            enctype="multipart/form-data">
                            {{-- <div class="row">
                            <span>
                                @php
                                $ids='';
                                @endphp
                                @foreach ($unusedids as $id)
                                @php  $ids.=$id->ids. ".<input class=UIDS type='radio' name='uid' value=$id->ids /> ". '&nbsp;&nbsp;' @endphp
                                @endforeach
                            </span>
                            <div class="alert alert-warning"><i class="fas fas-warning"></i>Un-Used System IDs: {!!$ids!!} <a href="{{url('client/create')}}" class="btn btn-warning btn-sm">Reset</a></div>
                        </div> --}}
                            @csrf

                            @include('client.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(function() {
            $('.UIDS').on('click', function() {
                id = $(this).val();
                alert(id);

            });
        })
    </script>
@endsection
