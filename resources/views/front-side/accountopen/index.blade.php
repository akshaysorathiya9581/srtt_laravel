@extends('front-side.layout.mainlayout')
@section('content')
 <div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li>
                        <a href="{{ route('accountopen.index') }}">Account Open Management</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                </ol>
            </div>
            <h4 class="page-title">
                <a href="{{ route('accountopen.index') }}" class="btn btn-danger waves-effect waves-light m-b-5 pull-left"> <i class="mdi mdi-reply-all"></i> <span> BACK</span></a>
            </h4>
        </div>
    </div>
</div>
<!-- end row -->

<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('accountopen.create') }}" class="btn btn-inverse waves-effect waves-light m-b-5 pull-right"> <i class="mdi mdi-plus"></i> <span> ADD NEW</span></a>
                </div>
            </div>
            <div class="row">
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
            </div>
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Reference Code</th>
                        <th>Name</th>
                        <th>Client Reference</th>
                        <th>Under</th>
                        <th>Created Date</th>
                        <th>Updated Date</th>
                        <th style="width:120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        var table =$('#datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "bDestroy": true,
            "ajax":{
                "url": "{{ route('accountopen.index') }}",
                "dataType": "json",
                'data': {"_token": "{{ csrf_token() }}"},
            },
            "columns": [
                { "data": "id" },
                { "data": "reference_code" },
                { "data": "name" },
                { "data": "client_reference" },
                { "data": "under" },
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
