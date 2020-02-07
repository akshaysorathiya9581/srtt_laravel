@extends('admin-side.layout.mainlayout')
@section('content')
<!-- end row -->
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-title-box">
                <h4 class="page-title">AIRLINE-GROUP </h4>
                <ol class="breadcrumb p-0 m-0">
                    <li class="active">
                        <a href="{{ route('airlineGroup.index') }}">BACK</a>
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
                <form action="{{ route('airlineGroup.updates') }}" METHOD="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">NAME<span class="text-danger">*</span></label>
                        <input type="text" name="name" placeholder="ENTER GROUP NAME" class="form-control" value="{{ old('name') }}">
                        @if ($errors->has('name')) <p style="color:red;">{{ $errors->first('name') }}</p> @endif
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
@endsection