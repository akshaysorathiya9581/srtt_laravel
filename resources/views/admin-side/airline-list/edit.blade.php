@extends('admin-side.layout.mainlayout')
@section('content')
<!-- end row -->
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-title-box">
                <h4 class="page-title">AIRLINE-LIST </h4>
                <ol class="breadcrumb p-0 m-0">
                    <li class="active">
                        <a href="{{ route('airlienList.index') }}">BACK</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard') }}">DASHBOARD</a>
                    </li>
                </ol>
                <div class="clearfix"></div>
            </div>
        </div>
    </div><!-- end row -->
    <div class="row">
        <div class="col-xs-12">
            <div class="card-box">
                <form action="{{ route('airlienList.update',$airlinelist['id'])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $airlinelist['id'] }}">
                    <div class="form-group">
                        <label for="userName">NAME<span class="text-danger">*</span></label>
                        <input type="text" name="name" placeholder="ENTER AIRLINE NAME" class="form-control input-sm" value="{{ $airlinelist['name'] }}">
                        @if ($errors->has('name')) <p style="color:red;">{{ $errors->first('name') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label for="emailAddress">MEMBERSHIP PLAN<span class="text-danger">*</span></label>
                        <select name="membership_plan" class="form-control input-sm">
                            <option value="">SELECT MEMBERSHIP PLAN</option>
                            <option value="YES" <?php echo $airlinelist['membership_plan'] == 'YES' ? 'selected="selected"' : '';?>>YES</option>
                            <option value="NO" <?php echo $airlinelist['membership_plan'] == 'NO' ? 'selected="selected"' : '';?>>NO</option>
                        </select>
                        @if ($errors->has('membership_plan')) <p style="color:red;">{{ $errors->first('membership_plan') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label for="">AIRLINE GROUP<span class="text-danger">*</span></label>
                        <select name="airline_group" class="form-control input-sm">
                            <option value="">SELECT AIRLINE GROUP</option>
                            @if (!(empty($airlineGroups)))
                                @foreach ($airlineGroups as $airlineGroup)
                                    <option value="{{ $airlineGroup['id'] }}" <?php echo $airlineGroup['id'] == $airlinelist['airline_group_id'] ? 'selected="selected"' : '';?>>{{ $airlineGroup['name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('airline_group')) <p style="color:red;">{{ $errors->first('airline_group') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label for="">AIRLINE GST<span class="text-danger">*</span></label>
                        <select name="airline_gst" class="form-control input-sm">
                            <option value="">SELECT AIRLINE GST</option>
                            <option value="0">FROM AIRLINE</option>
                            <option value="1">FROM WEBSITE</option>
                        </select>
                        @if ($errors->has('airline_gst')) <p style="color:red;">{{ $errors->first('airline_gst') }}</p> @endif
                    </div>
                    <div class="airline-gst"></div>
                    <div class="form-group">
                        <label for="pass1">LOGO<span class="text-danger">*</span></label>
                        <input  type="file" class="form-control input-sm" name="logo">
                        @if ($errors->has('logo')) <p style="color:red;">{{ $errors->first('logo') }}</p> @endif
                    </div>
                   
                    <div class="form-group text-right m-b-0">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">SAVE</button>
                        <button type="reset" class="btn btn-default waves-effect m-l-5">Cancel</button>
                    </div>
                </form>
            </div> <!-- end card-box -->
        </div><!-- end col-->
    </div>
<!-- end row -->
</div>
@php
    $airline_gst = $airlinelist['airline_gst'];
    $url = $airlinelist['url'];
    $email = $airlinelist['email'];
    $phone_number = $airlinelist['phone_number'];
    $contact_person = $airlinelist['contact_person'];
@endphp
   
@endsection
@push('scripts')
    <script src="{{asset('public/admin-side/js/modules/airlinelistController.js')}}"></script>
    <script>
        $(document ).ready(function() {
            $(document).on('change', 'select[name="airline_gst"]', function(event) {
                event.preventDefault();
                var $this = $(this);
                var val = $this.val();
                var html = '';
                if(val == '0') {
                    html += '<div class="form-group">';
                            html +='<label class="control-label mb-10 text-left">EMAIL<span class="text-danger">*</span></label>';
                            html += '<input type="text" name="email" class="form-control input-sm" placeholder="ENTER EMAIL" autocomplete="off" value="{{ old('email') }}">';
                            html += '@if ($errors->has('email')) <p style="color:red;">{{ $errors->first('email') }}</p> @endif';
                        html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                            html +='<label class="control-label mb-10 text-left">PHONE NUMBER<span class="text-danger">*</span></label>';
                            html += '<input type="text" name="phone_number" class="form-control input-sm" placeholder="ENTER PHONE NUMBER" autocomplete="off" value="{{ old('phone_number') }}">';
                            html += '@if ($errors->has('phone_number')) <p style="color:red;">{{ $errors->first('phone_number') }}</p> @endif';
                        html += '</div>';
                    html += '</div>'; 
                    html += '<div class="form-group">';
                            html += '<label class="control-label mb-10 text-left">CONTACT PERSON<span class="text-danger">*</span></label>';
                            html += '<input type="text" name="contact_person" class="form-control input-sm" placeholder="ENTER CONTACT PERSON" autocomplete="off" value="{{ old('contact_person') }}">';
                            html += '@if ($errors->has('contact_person')) <p style="color:red;">{{ $errors->first('contact_person') }}</p> @endif';
                        html += '</div>';
                    html += '</div>';
                } else {
                    html += '<div class="form-group">';
                            html +='<label class="control-label mb-10 text-left">EMAIL<span class="text-danger">*</span></label>';
                            html += '<input type="text" name="url" class="form-control input-sm" placeholder="ENTER AIRLINE URL" autocomplete="off" value="{{ old('url') }}">';
                            html += '@if ($errors->has('url')) <p style="color:red;">{{ $errors->first('url') }}</p> @endif';
                        html += '</div>';
                    html += '</div>';
                }
                
                $('.airline-gst').html(html);
            });
            $('select[name="airline_gst"]').val('{!! $airlinelist["airline_gst"] !!}').trigger('change');
            $('input[name="url"]').val('{!! $airlinelist["url"] !!}');
            $('input[name="email"]').val('{!! $airlinelist["email"] !!}');
            $('input[name="phone_number"]').val('{!! $airlinelist["phone_number"] !!}');
            $('input[name="contact_person"]').val('{!! $airlinelist["contact_person"] !!}');
         
        });
    </script>
@endpush