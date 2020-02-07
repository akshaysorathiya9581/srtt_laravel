@extends('admin-side.layout.mainlayout')
@section('content')
<!-- end row -->
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-title-box">
                <h4 class="page-title">CREATE NEW USER </h4>
                <ol class="breadcrumb p-0 m-0">
                    <li class="active">
                        <a href="{{ route('users.index') }}">BACK</a>
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
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="userName">NAME<span class="text-danger">*</span></label>
                        <input type="text" name="name" placeholder="ENTER USERNAME" class="form-control input-sm" value="{{ old('name') }}" autocomplete="off">
                        @if ($errors->has('name')) <p style="color:red;">{{ $errors->first('name') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label for="userName">EMAIL<span class="text-danger">*</span></label>
                        <input type="text" name="email" placeholder="ENTER EMAIL" class="form-control input-sm" value="{{ old('email') }}" autocomplete="off">
                        @if ($errors->has('email')) <p style="color:red;">{{ $errors->first('email') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label for="userName">PASSWORD<span class="text-danger">*</span></label>
                        <input type="text" name="password" placeholder="ENTER PASSWORD" class="form-control input-sm" value="{{ old('password') }}" autocomplete="off">
                        @if ($errors->has('password')) <p style="color:red;">{{ $errors->first('password') }}</p> @endif
                    </div>
                        <div class="form-group">
                            <label for="userName">CONFIRM PASSWORD<span class="text-danger">*</span></label>
                            <input type="text" name="confirm-password" placeholder="ENTER CONFIRM PASSWORD" class="form-control input-sm" value="{{ old('password') }}" autocomplete="off">
                            @if ($errors->has('password')) <p style="color:red;">{{ $errors->first('password') }}</p> @endif
                        </div>
                    <div class="form-group">
                        <label for="">ROLES<span class="text-danger">*</span></label>
                        <select name="roles" class="form-control input-sm">
                            <option value="">SELECT ROLES</option>
                            @if (!(empty($roles)))
                                @foreach ($roles as $role)
                                    <option value="{{ $role['id'] }}" @if(old('roles') == $role['id']) selected @endif>{{ $role['name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('roles')) <p style="color:red;">{{ $errors->first('roles') }}</p> @endif
                    </div>
                     @foreach($permission as $value)
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="permission[]" value="{{ $value->id }}"> {{ $value->name }} 
                                </label>
                            </div>
                        </div>
                    @endforeach
                   <!--  <div class="rolePermission"></div> -->
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
@endsection
@push('scripts')
    <script>
        $(document).on('change', 'select[name="roles"]', function(event) {
            event.preventDefault();
            var $this = $(this);
            var id = $this.val();
            $.ajax({
                method: "POST",
                url: "{{ route('getRolePermission')}}",
                data: {
                "_token": "{{ csrf_token() }}",
                "id": id
                }
                }).done(function( data ) {

                var html = '';
                $.each(data.data,function(index, el) {
                    html +='<div class="col-md-3">';
                         html += '<div class="form-group">';
                            html +='<label class="checkbox-inline">';
                                 html +='<input type="checkbox" name="permission[]" value="'+el.id+'">'+el.name+'</label>';
                         html +='</div>';
                    html +='</div>'
                });
                $('.rolePermission').html(html);
            });
        });
       
    </script>
@endpush
