<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="area">Area</label>
                    <select class="form-control" id="area" name="area" required>
                                  
                        @foreach($area as $a)
                        <option value="{{$a->id}}">{{$a->name}}</option>
                        @endforeach
                    </select>
                </div> 
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Account Name</label>
                    <input type="text" class="form-control" id="account_name" value="{{Request::old('account_name')}}" required name="account_name" placehRequest::older="Account Name">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Phone Number</label>
                    <input type="number" class="form-control"  required  id="phone_no" value="{{Request::old('phone_no')}}" name="phone_no" placehRequest::older="Phone Number">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{Request::old('email')}}" placehRequest::older="Email Address">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">ID Number</label>
                    <input type="number" class="form-control"  required  id="national_id" value="{{Request::old('national_id')}}" name="national_id" placehRequest::older="ID Number">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Plot Number</label>
                    <input type="text" class="form-control" id="plot_number" name="plot_number" value="{{Request::old('plot_number')}}"  placehRequest::older="Plot Number">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Account Open Date</label>
                    <input type="text" class="form-control datepicker" readonly id="account_open_date" value="{{Request::old('account_open_date') ? Request::old('account_open_date') : date('Y-m-d')}}" name="account_open_date"  >
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">KRA PIN</label>
                    <input type="text" class="form-control" id="kra_pin"  required  name="kra_pin"  value="{{Request::old('kra_pin')}}" data-date-format="DD MMMM YYYY" placeholder="KRA PIN">
                </div>
            </div>            <div class="col-6">              
                <div class="form-group">
                    <label for="exampleFormControlInput1">Meter Number</label>
                    <input type="text" class="form-control" id="meter_number" name="meter_number" value="{{Request::old('meter_number')}}" placehRequest::older="Meter Number">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlSelect2">Account Status</label>
                    <select  class="form-control" id="status" name="status"  required >
                                
                        @foreach($status as $a)
                        <option value="{{$a->id}}">{{$a->status}}</option>
                        @endforeach
                    </select>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Avatar</label>
                    <input type="file" class="form-control" id="avatar" name="avatar" placehRequest::older="Avatar">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Connection Date</label>
                    <input type="text" class="form-control datepicker" id="connection_date" value="{{Request::old('connection_date') ? Request::old('connection_date') : date('Y-m-d')}}" name="connection_date">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Vacation Date</label>
                    <input type="text" class="form-control datepicker" id="vaccation_date" value="{{Request::old('vaccation_date')}}" name="vaccation_date" placehRequest::older="Vacation Date">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Reconnection Date</label>
                    <input type="text" class="form-control datepicker" id="reconnection_date" value="{{Request::old('reconnection_date')}}" name="reconnection_date" placehRequest::older="Reconnection Date">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Meter Reading Date</label>
                    <input type="text" class="form-control datepicker" id="meter_reading_date" value="{{Request::old('meter_reading_date')}}" name="meter_reading_date" placehRequest::older="Meter Reading Date">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Comments</label>
                    <textarea class="form-control" id="comment" name="comment" placehRequest::older="Any Comment" rows="3">{{Request::old('comment')}}"</textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <input type="submit" class="btn btn-md btn-primary" id="submit" value="Submit"/>
                </div>
            </div>

        </div>


    </div>
</div>