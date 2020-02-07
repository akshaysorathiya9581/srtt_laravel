@extends('front-side.layout.mainlayout')
@section('content')
<!-- end row -->

   <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="btn-group pull-right">
                    <ol class="breadcrumb hide-phone p-0 m-0">
                        <li>
                            <a href="javascript:void(0);">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('paxprofile.index') }}">Pax Profile</a>
                        </li>
                        <li class="active">
                            Edit Pax Profile
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Pax Profile</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="card-box">
                <form action="{{ route('paxprofile.update',$data['id']) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="f_name">FIRST NAME<span class="text-danger">*</span></label>
                                <input type="text" name="f_name" placeholder="Enter First Name" class="form-control " value="{{ $data['client_details']['f_name'] }}" autocomplete="off">
                                @if ($errors->has('f_name')) <p style="color:red;">{{ $errors->first('f_name') }}</p> @endif
                            </div>
                        </div> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="m_name">MIDDLE NAME</label>
                                <input type="text" name="m_name" placeholder="Enter Middle Name" class="form-control " value="{{ $data['client_details']['m_name'] }}" autocomplete="off">
                                @if ($errors->has('m_name')) <p style="color:red;">{{ $errors->first('m_name') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="l_name">LAST NAME<span class="text-danger">*</span></label>
                                <input type="text" name="l_name" placeholder="Enter Last Name" class="form-control " value="{{ $data['client_details']['l_name'] }}" autocomplete="off">
                                @if ($errors->has('l_name')) <p style="color:red;">{{ $errors->first('l_name') }}</p> @endif
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="dob">DOB<span class="text-danger">*</span></label>
                                <input type="text" name="dob" placeholder="Enter Dob" class="form-control date" value="{{ date('d-m-Y',strtotime($data['client_details']['l_name'])) }}" autocomplete="off">
                                @if ($errors->has('dob')) <p style="color:red;">{{ $errors->first('dob') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="place">PLACE<span class="text-danger">*</span></label>
                                <input type="text" name="place" placeholder="Enter Place" class="form-control " value="{{ $data['client_details']['place'] }}" autocomplete="off">
                                @if ($errors->has('place')) <p style="color:red;">{{ $errors->first('place') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="gender">GENDER<span class="text-danger">*</span></label><br>
                                <div class="radio radio-info radio-inline">
                                    <input type="radio" id="male" value="male" name="gender" {{ $data['client_details']['gender'] == 'male' ? 'checked' : '' }}>
                                    <label for="male"> MALE </label>
                                </div>
                                <div class="radio radio-info radio-inline">
                                    <input type="radio" id="female" value="female" name="gender" {{ $data['client_details']['gender'] == 'female' ? 'checked' : '' }}>
                                    <label for="female"> FEMALE </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">EMAIL<span class="text-danger">*</span></label>
                                <input type="text" name="email" placeholder="Enter Email" class="form-control " value="{{ $data['email'] }}" autocomplete="off">
                                @if ($errors->has('email')) <p style="color:red;">{{ $errors->first('email') }}</p> @endif
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="con_coun_code">Country Code<span class="text-danger">*</span></label>
                                <select name="phone_coun_code" class="form-control  select2">
                                    <option value="">Select Country Code</option>
                                    @if (!(empty($countrys)))
                                        @foreach($countrys as $country)
                                              <option value="{{ $country->phonecode }}">{{ strtoupper($country->name.'  +'.$country->phonecode) }}</option>
                                        @endforeach;
                                    @endif;
                                </select>
                                @if ($errors->has('phone_coun_code')) <p style="color:red;">{{ $errors->first('phone_coun_code') }}</p> @endif
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Phone number<span class="text-danger">*</span></label>
                                <input type="text" name="phone_number" placeholder="Enter Phone Number" class="form-control  " value="{{ old('phone_number') }}" autocomplete="off">
                                @if ($errors->has('phone_number')) <p style="color:red;">{{ $errors->first('phone_number') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="con_coun_code">Country Code<span class="text-danger">*</span></label>
                                <select name="whatsapp_coun_code" class="form-control select2">
                                    <option value="">Select Country Code</option>
                                     @if (!(empty($countrys)))
                                        @foreach($countrys as $country)
                                              <option value="{{ $country->phonecode }}">{{ strtoupper($country->name.'  +'.$country->phonecode) }}</option>
                                        @endforeach;
                                    @endif;
                                </select>
                                @if ($errors->has('whatsapp_coun_code')) <p style="color:red;">{{ $errors->first('whatsapp_coun_code') }}</p> @endif
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Whatsapp Number<span class="text-danger">*</span></label>
                                <input type="text" name="whatsapp_number" placeholder="Enter Whatsapp Number" class="form-control " value="{{ old('whatsapp_number') }}" autocomplete="off">
                                @if ($errors->has('whatsapp_number')) <p style="color:red;">{{ $errors->first('whatsapp_number') }}</p> @endif
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="meal_pre">MEAL PREFERENCE:<span class="text-danger">*</span></label>
                                <select name="meal_pre" class="form-control select2">
                                    <option value="">Select Service</option>
                                     @if (!(empty($mealPreferences)))
                                        @foreach($mealPreferences as $mealPreference)
                                              <option value="{{ $mealPreference['short_name'] }}">{{ $mealPreference['name'] }}</option>
                                        @endforeach;
                                    @endif;
                                </select>
                                @if ($errors->has('meal_pre')) <p style="color:red;">{{ $errors->first('meal_pre') }}</p> @endif
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="seat_pre">SEAT PREFERENCE:<span class="text-danger">*</span></label>
                                <select name="seat_pre" class="form-control select2">
                                    <option value="">Select Seat Preference:</option>
                                    @if (!(empty($seatPreferences)))
                                        @foreach($seatPreferences as $seatPreference)
                                              <option value="{{ $seatPreference['id'] }}">{{ $seatPreference['name'] }}</option>
                                        @endforeach;
                                    @endif;
                                </select>
                                @if ($errors->has('seat_pre')) <p style="color:red;">{{ $errors->first('seat_pre') }}</p> @endif
                            </div>
                        </div> 
                    </div> 
                    <div class="form-group text-right m-b-0">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">SAVE</button>
                        <button type="reset" class="btn btn-danger waves-effect m-l-5">Cancel</button>
                    </div>
                </form>
            </div> <!-- end card-box -->
        </div><!-- end col-->
    </div>
@endsection
@push('scripts')
    <script>
        jQuery(document).ready(function () {
            $(".select2").select2();
        });
    </script>
@endpush
