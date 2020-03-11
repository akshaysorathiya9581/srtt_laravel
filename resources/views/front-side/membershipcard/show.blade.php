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
                            <a href="{{ route('membershipcard.index') }}">Membership Card Details</a>
                        </li>
                        <li class="active">
                            Show MembershipCard
                        </li>
                    </ol>
                </div>
                <h4 class="page-title">Show Membership Card</h4>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div class="table-responsive">
                <table class="table table-bordered m-b-0">
                    <tbody>
                        <tr>
                            <th scope="row">Name:</th>
                            <td>{{ $membershipCards['client_details']['f_name'] .' '.$membershipCards['client_details']['m_name'] .' '.$membershipCards['client_details']['l_name'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Airline Name: </th>
                            <td>{{ $membershipCards['airline_details']['name'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Membership Number:</th>
                            <td>{{ $membershipCards['membership_number']}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Password:</th>
                            <td>{{ $membershipCards['password'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Email:</th>
                            <td>{{ $membershipCards['email'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Phone Number:</th>
                            <td>{{ $membershipCards['phone_number'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Security Question:</th>
                            <td>{{ $membershipCards['securi_quest'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Security Question Answer:</th>
                            <td>{{ $membershipCards['secu_ques_ans'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Family Program:</th>
                            <td>{{ $membershipCards['family_program'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Family Head:</th>
                            <td>{{ $membershipCards['family_head'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Membership Card:</th>
                            <td>
                                @php
                                    $cards = explode(',',$membershipCards['attached']);
                                @endphp
                                @foreach ($cards as $card)
                                <div class="col-sm-4">
                                    <img src="{{ url("public/membershipcard/{$card}")}}" alt="image" class="img-responsive thumb-lg">
                                </div>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Created By:</th>
                            <td>{{ $membershipCards['created_by']['name'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Updated By:</th>
                            <td>{{ $membershipCards['updated_by'] != 'null' ? $membershipCards['updated_by']['name'] : '' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Created Date:</th>
                            <td>{{ date('d-m-Y H:i:s',strtotime($membershipCards['created_at'])) }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Updated Date:</th>
                            <td>{{ date('d-m-Y H:i:s',strtotime($membershipCards['updated_at'])) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- end card-box -->

    </div>
</div>
@endsection
