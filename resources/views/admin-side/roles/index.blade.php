@extends('admin-side.layout.mainlayout')
@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="page-title-box">
            <h4 class="page-title">Role Management </h4>
            <ol class="breadcrumb p-0 m-0">
                <li class="active">
                    <a href="{{ route('roles.index') }}">BACK</a>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}">DASHBOARD</a>
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
	</div>
</div>
<!-- end row -->


<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
             <div class="col-md-12">
                @if (Session::has('message'))
                    <div class="alert alert-icon alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <i class="mdi mdi-check-all"></i>
                        <strong>SUCCESS !</strong> {{ Session::get('message') }}
                    </div>
                @endif
            </div>
            <div class="col-md-12">
                    <a href="{{ route('roles.create') }}" class="btn btn-inverse waves-effect waves-light m-b-5 pull-right"> <i class="mdi mdi-plus"></i> <span> ADD NEW</span> </a>
            </div>

            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>NO</th>
                    <th>NAME</th>
                    <th>CREATED DATE</th>
                    <th>UPDATED DATE</th>
                    <th>ACTION</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div><!-- end row -->
@endsection
@push('scripts')
    <script src="{{asset('public/admin-side/js/modules/airlinelistController.js')}}"></script>
    <script>
        var table =$('#datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "bDestroy": true,
            "ajax":{
                "url": "{{ route('roles.index') }}",
                "dataType": "json",
                'data': {"_token": "{{ csrf_token() }}"},
            },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "created_at" },
                { "data": "updated_at" },
                { "data": "action" }
            ]	 
        });

        $(document).on('click','.delete-btn',function(){
            var $this = $(this);
            var id = $this.data('id');
            $this.find('form').submit();
        });
    </script>
@endpush