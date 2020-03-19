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
                            <a href="{{ route('accountopen.index') }}">Account Open Request</a>
                        </li>
                        <li class="active">
                            Add New Account Open Request
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">Add New Account Open Request</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="card-box">
                <form action="{{ route('accountopen.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="account_name">NAME<span class="text-danger">*</span></label>
                                <input type="text" name="account_name" placeholder="Enter Account Name" class="form-control " value="{{ old('v') }}" autocomplete="off">
                                @if ($errors->has('account_name')) <p style="color:red;">{{ $errors->first('account_name') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="client_referance">CLIENT REFERANCE:<span class="text-danger">*</span></label>
                                <input type="text" name="client_referance" placeholder="Enter Client Referance" class="form-control " value="{{ old('client_referance') }}" autocomplete="off">
                                @if ($errors->has('client_referance')) <p style="color:red;">{{ $errors->first('client_referance') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="under">Under<span class="text-danger">*</span></label>
                                <select name="under" class="form-control select2">
                                    <option value="">Select Under</option>
                                     @if (!(empty($unders)))
                                        @foreach($unders as $under)
                                              <option value="{{ $under['id'] }}"  @if(old('under') == $under['id']) selected @endif>{{ strtoupper($under['name']) }}</option>
                                        @endforeach;
                                    @endif;
                                </select>
                                @if ($errors->has('under')) <p style="color:red;">{{ $errors->first('under') }}</p> @endif
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
        jQuery(document).ready(function() {
            $(".select2").select2();

            $(document).on('change','select[name="under"]',function(){

            });
        });
    </script>
@endpush
