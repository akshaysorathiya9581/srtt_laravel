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
                            <a href="{{ route('crm.index') }}">Crm</a>
                        </li>
                        <li class="active">
                            Add New Crm
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">Add New Crm</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="card-box">
                <form action="{{ route('roles.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Name<span class="text-danger">*</span></label>
                                <input type="text" name="name" placeholder="Enter Client Name" class="form-control " value="{{ old('name') }}" autocomplete="off">
                                @if ($errors->has('name')) <p style="color:red;">{{ $errors->first('name') }}</p> @endif
                            </div>
                        </div> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Email<span class="text-danger">*</span></label>
                                <input type="text" name="email" placeholder="Enter Email" class="form-control " value="{{ old('email') }}" autocomplete="off">
                                @if ($errors->has('email')) <p style="color:red;">{{ $errors->first('email') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Place<span class="text-danger">*</span></label>
                                <input type="text" name="place" placeholder="Enter Place" class="form-control " value="{{ old('place') }}" autocomplete="off">
                                @if ($errors->has('place')) <p style="color:red;">{{ $errors->first('place') }}</p> @endif
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="con_coun_code">Country Code<span class="text-danger">*</span></label>
                                <select name="phone_coun_code" class="form-control  select2">
                                    <option value="">Select Country Code</option>
                                    <option value="91">+91</option>
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
                                    <option value="91">91</option>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="service">Service<span class="text-danger">*</span></label>
                                <select name="service" class="form-control select2">
                                    <option value="">Select Service</option>
                                     @if (!(empty($services)))
                                        @foreach($services as $service)
                                              <option value="{{ $service['id'] }}">{{ $service['name'] }}</option>
                                        @endforeach;
                                    @endif;
                                </select>
                                @if ($errors->has('service')) <p style="color:red;">{{ $errors->first('service') }}</p> @endif
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
