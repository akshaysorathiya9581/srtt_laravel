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
                            <a href="{{ route('protector.index') }}">Login Protector</a>
                        </li>
                        <li class="active">
                            Edit Login Protector
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Login Protector</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="card-box">
                <form action="{{ route('protector.update',$data['id'])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $data['id'] }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="login_for">Login For<span class="text-danger">*</span></label>
                                <input type="text" name="login_for" placeholder="Enter Login For" class="form-control " value="{{ $data['login_for'] }}" autocomplete="off">
                                @if ($errors->has('login_for')) <p style="color:red;">{{ $errors->first('login_for') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="service">Login For Which Service<span class="text-danger">*</span></label>
                                <select name="service[]" class="form-control select2" multiple="multiple">
                                    <option value="">Select Login For Which Service</option>
                                     @if (!(empty($services)))
                                        @foreach($services as $service)
                                            @php $selected = $data['service_id'] == $service->id ? 'selected="selected"' : ''; @endphp
                                            <option value="{{ $service->id }}" @php echo  $selected; @endphp;>{{ strtoupper($service->name) }}</option>
                                        @endforeach;
                                    @endif;
                                </select>
                                @if ($errors->has('service')) <p style="color:red;">{{ $errors->first('service') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="terminal_id">Terminal Id<span class="text-danger">*</span></label>
                                <input type="text" name="terminal_id" placeholder="Enter Terminal Id" class="form-control " value="{{ $data['terminal_id'] }}" autocomplete="off">
                                @if ($errors->has('terminal_id')) <p style="color:red;">{{ $errors->first('terminal_id') }}</p> @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" placeholder="Enter Name" class="form-control " value="{{ $data['name'] }}" autocomplete="off">
                                @if ($errors->has('name')) <p style="color:red;">{{ $errors->first('name') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="password">Password<span class="text-danger">*</span></label>
                                <input type="text" name="password" placeholder="Enter Password" class="form-control " value="{{ $data['password'] }}" autocomplete="off">
                                @if ($errors->has('password')) <p style="color:red;">{{ $errors->first('password') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="website">Website<span class="text-danger">*</span></label>
                                <input type="text" name="website" placeholder="Enter Website" class="form-control " value="{{ $data['website'] }}" autocomplete="off">
                                @if ($errors->has('website')) <p style="color:red;">{{ $errors->first('website') }}</p> @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="contact_number">Contact Number<span class="text-danger">*</span></label>
                                <input type="text" name="contact_number" placeholder="Enter Contact Number" class="form-control" value="{{ $data['contact_number'] }}" autocomplete="off">
                                @if ($errors->has('contact_number')) <p style="color:red;">{{ $errors->first('contact_number') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="support_name">Urgent Support Name<span class="text-danger">*</span></label>
                                <input type="text" name="support_name" placeholder="Enter Urgent Support Name" class="form-control" value="{{ $data['support_name'] }}" autocomplete="off">
                                @if ($errors->has('support_name')) <p style="color:red;">{{ $errors->first('support_name') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="support_number">Urgent Support Number<span class="text-danger">*</span></label>
                                <input type="text" name="support_number" placeholder="Enter Urgent Support Number" class="form-control" value="{{ $data['support_number'] }}" autocomplete="off">
                                @if ($errors->has('support_number')) <p style="color:red;">{{ $errors->first('support_number') }}</p> @endif
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
