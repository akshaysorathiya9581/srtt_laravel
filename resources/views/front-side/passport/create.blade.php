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
                            <a href="{{ route('passport.index') }}">Passport</a>
                        </li>
                        <li class="active">
                            Add New Passport
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">Add New Passport</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="card-box">
                <form action="{{ route('passport.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="client">Client Name<span class="text-danger">*</span></label>
                                <select name="client" class="form-control select2">
                                    <option value="">Select Client Name</option>
                                     @if (!(empty($clients)))
                                        @foreach($clients as $client)
                                              <option value="{{ $client['id'] }}">{{ strtoupper($client['f_name'].' '.$client['m_name'].' '.$client['l_name']) }}</option>
                                        @endforeach;
                                    @endif;
                                </select>
                                @if ($errors->has('client')) <p style="color:red;">{{ $errors->first('client') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="passport_number">Passport Number<span class="text-danger">*</span></label>
                                <input type="text" name="passport_number" placeholder="Enter Passport Number" class="form-control " value="{{ old('passport_number') }}" autocomplete="off">
                                @if ($errors->has('passport_number')) <p style="color:red;">{{ $errors->first('passport_number') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="issue_date">Passport Issue Date</label>
                                <input type="text" name="issue_date" placeholder="Enter Passport Issue Date" class="form-control " value="{{ old('issue_date') }}" autocomplete="off">
                                @if ($errors->has('issue_date')) <p style="color:red;">{{ $errors->first('issue_date') }}</p> @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="issue_place">Passport Issue Place<span class="text-danger">*</span></label>
                                <input type="text" name="issue_place" placeholder="Enter Passport Issue Place" class="form-control " value="{{ old('issue_place') }}" autocomplete="off">
                                @if ($errors->has('issue_place')) <p style="color:red;">{{ $errors->first('issue_place') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="expiry_date">Passport Expiry Date<span class="text-danger">*</span></label>
                                <input type="text" name="expiry_date" placeholder="Enter Passport Expiry Date" class="form-control " value="{{ old('expiry_date') }}" autocomplete="off">
                                @if ($errors->has('expiry_date')) <p style="color:red;">{{ $errors->first('expiry_date') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dob">Date Of Birth:<span class="text-danger">*</span></label>
                                <input type="text" name="dob" placeholder="Enter Dob" class="form-control birth" value="{{ old('dob') }}" autocomplete="off">
                                @if ($errors->has('dob')) <p style="color:red;">{{ $errors->first('dob') }}</p> @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ecr">ECR/ECNR:<span class="text-danger">*</span></label>
                                <select name="ecr" class="form-control select2">
                                    <option value="">Select Ecr/Ecnr</option>
                                    <option value="EMIGRATION CHECK REQUIRED">EMIGRATION CHECK REQUIRED</option>
                                    <option value="EMIGRATION CHECK NOT REQUIRED">EMIGRATION CHECK NOT REQUIRED</option>
                                </select>
                                @if ($errors->has('ecr')) <p style="color:red;">{{ $errors->first('ecr') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nationality">Nationality<span class="text-danger">*</span></label>
                                <select name="nationality" class="form-control select2">
                                    <option value="">Select Country</option>
                                     @if (!(empty($countrys)))
                                        @foreach($countrys as $country)
                                              <option value="{{ $country->id }}">{{ strtoupper($country->name) }}</option>
                                        @endforeach;
                                    @endif;
                                </select>
                                @if ($errors->has('nationality')) <p style="color:red;">{{ $errors->first('nationality') }}</p> @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>File Uploads</label><span class="text-danger">*</span>
                                    <input type="file" name="files[]" id="filer_input1" multiple="multiple">
                                </div>
                                @if ($errors->has('files')) <p style="color:red;">{{ $errors->first('files') }}</p> @endif
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
