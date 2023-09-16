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
        {{-- <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Application Fee(KES.)</label>
                    <input type="text" class="form-control" id="application_fee" value="{{Request::old('application_fee')}}" required name="application_fee" placeholder="Application Fee e.g. 20,000.00">
                </div>
            </div>
            <div class="col-6">

            </div>
        </div> --}}
  

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Phone Number</label>
                    <input type="number" class="form-control"  required  id="phone_no" value="{{Request::old('phone_no')}}" name="phone_no" placehRequest::older="Phone Number">
                </div>
            </div>        
        </div>
      
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Account Open Date</label>
                    <input type="text" class="form-control datepicker" readonly id="account_open_date" value="{{Request::old('account_open_date') ? Request::old('account_open_date') : date('Y-m-d')}}" name="account_open_date"  >
                </div>
            
            </div> 
            <div class="col-6">              
                <div class="form-group">
                    <label for="exampleFormControlInput1">Account/Meter/House Number (For Tenants accounts must begin with PVA and for meter number is just Numbers)</label>
                    <input type="text" class="form-control" id="meter_number"  name="meter_number" value="{{Request::old('meter_number')}}" placeholder="Meter Number">
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