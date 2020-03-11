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
                            <a href="{{ route('membershipcard.index') }}">Membership Card</a>
                        </li>
                        <li class="active">
                            Add New MembershipCard
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">Add New Membershp Card</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="card-box">
                <form action="{{ route('membershipcard.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="client">Client Name<span class="text-danger">*</span></label>
                                <select name="client" class="form-control select2">
                                    <option value="">Select Client Name</option>
                                     @if (!(empty($clients)))
                                        @foreach($clients as $client)
                                            @php $selected = $data['client_id'] == $client['id'] ? 'selected="selected"' : ''; @endphp
                                            <option value="{{ $client['id'] }}"  @php echo  $selected; @endphp;>{{ strtoupper($client['f_name'].' '.$client['m_name'].' '.$client['l_name']) }}</option>
                                        @endforeach;
                                    @endif;
                                </select>
                                @if ($errors->has('client')) <p style="color:red;">{{ $errors->first('client') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="airline">Airline Name<span class="text-danger">*</span></label>
                                <select name="airline" class="form-control select2">
                                    <option value="">Select Airline Name</option>
                                     @if (!(empty($airlinelists)))
                                        @foreach($airlinelists as $airlinelist)
                                            @php $selected = $data['airline_id'] == $airlinelist->id ? 'selected="selected"' : ''; @endphp
                                            <option value="{{ $airlinelist->id }}"  @php echo  $selected; @endphp;>{{ strtoupper($airlinelist->name) }}</option>
                                        @endforeach;
                                    @endif;
                                </select>
                                @if ($errors->has('airline')) <p style="color:red;">{{ $errors->first('airline') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="membership_number">Membership Number<span class="text-danger">*</span></label>
                                <input type="text" name="membership_number" placeholder="Enter Membership Number" class="form-control " value="{{ $data['membership_number'] }}" autocomplete="off">
                                @if ($errors->has('membership_number')) <p style="color:red;">{{ $errors->first('membership_number') }}</p> @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" name="password" placeholder="Enter Password" class="form-control " value="{{ $data['password'] }}" autocomplete="off">
                                @if ($errors->has('password')) <p style="color:red;">{{ $errors->first('password') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email<span class="text-danger">*</span></label>
                                <input type="text" name="email" placeholder="Enter Email" class="form-control " value="{{ $data['email'] }}" autocomplete="off">
                                @if ($errors->has('email')) <p style="color:red;">{{ $errors->first('email') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone_number">Phone Number<span class="text-danger">*</span></label>
                                <input type="text" name="phone_number" placeholder="Enter Phone Number" class="form-control " value="{{ $data['phone_number'] }}" autocomplete="off">
                                @if ($errors->has('phone_number')) <p style="color:red;">{{ $errors->first('phone_number') }}</p> @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="securi_quest">Securit Question<span class="text-danger">*</span></label>
                                <input type="text" name="securi_quest" placeholder="Enter Security Question" class="form-control" value="{{ $data['securi_quest'] }}" autocomplete="off">
                                @if ($errors->has('securi_quest')) <p style="color:red;">{{ $errors->first('securi_quest') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="email">Security Question Answer<span class="text-danger">*</span></label>
                                <input type="text" name="secu_ques_ans" placeholder="Enter Security Question Answer" class="form-control" value="{{ $data['secu_ques_ans'] }}" autocomplete="off">
                                @if ($errors->has('secu_ques_ans')) <p style="color:red;">{{ $errors->first('secu_ques_ans') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="family_program">Family Program<span class="text-danger">*</span></label>
                                <input type="text" name="family_program" placeholder="Enter Family Program" class="form-control " value="{{ $data['family_program'] }}" autocomplete="off">
                                @if ($errors->has('family_program')) <p style="color:red;">{{ $errors->first('family_program') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="family_head">Family Head<span class="text-danger">*</span></label>
                                <input type="text" name="family_head" placeholder="Enter Family Head" class="form-control" value="{{ $data['family_head'] }}" autocomplete="off">
                                @if ($errors->has('family_head')) <p style="color:red;">{{ $errors->first('family_head') }}</p> @endif
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
