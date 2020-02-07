@extends('front-side.layout.mainlayout')
@section('content')
 <div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li>
                        <a href="{{ route('crm.index') }}">Crm Management</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                </ol>
            </div>
            <h4 class="page-title">
                <a href="{{ route('crm.index') }}" class="btn btn-danger waves-effect waves-light m-b-5 pull-left"> <i class="mdi mdi-reply-all"></i> <span> BACK</span></a>
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
                    <a href="{{ route('crm.create') }}" class="btn btn-inverse waves-effect waves-light m-b-5 pull-right"> <i class="mdi mdi-plus"></i> <span> ADD NEW</span></a>
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
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011/04/25</td>
                        <td>$320,800</td>
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