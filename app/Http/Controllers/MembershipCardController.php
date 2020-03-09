<?php

namespace App\Http\Controllers;

use App\MembershipCard;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Auth;

class MembershipCardController extends Controller
{
    use CommonTrait;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = array(
                0 => 'id',
                1 => 'reference_code',
                2 => 'name',
                3 => 'place',
                4 => 'dob',
                5 => 'created_at',
                6 => 'updated_at',
                7 => 'id',
            );

            $totalData = MembershipCard::count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            // echo  $start; die();
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if(empty($request->input('search.value'))) {
                $membershipCards = MembershipCard::with(['clientDetails','countryDetails'])->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get()
                                    ->toArray();
                // dd($paxprofiles->toArray());
            } else {
                $search = $request->input('search.value');

                $membershipCards =  MembershipCard::with(['clientDetails','countryDetails'])->where('id','LIKE',"%{$search}%")
                                    ->orWhere('passport_number', 'LIKE',"%{$search}%")
                                    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get()
                                    ->toArray();

                $totalFiltered = MembershipCard::where('id','LIKE',"%{$search}%")
                                    ->orWhere('passport_number', 'LIKE',"%{$search}%")
                                    ->count();
            }
            // dd($passports);
            $data = array();
            if(!empty($membershipCards)){
                foreach ($membershipCards as $membershipCard) {
                    // dd($paxprofile);
                    $show =  route('membershipcard.show',$membershipCard['id']);
                    $edit =  route('membershipcard.edit',$membershipCard['id']);

                    $nestedData['id'] = $membershipCard['id'];
                    $nestedData['name'] = $membershipCard['client_details']['f_name'].' '.$membershipCard['client_details']['m_name'].' '.$membershipCard['client_details']['l_name'];
                    $nestedData['passport_number'] = $membershipCard['passport_number'];
                    $nestedData['issue_date'] = date('d-m-Y',strtotime($membershipCard['issue_date']));
                    $nestedData['issue_place'] = $membershipCard['issue_place'];
                    $nestedData['expiry_date'] = date('d-m-Y',strtotime($membershipCard['expiry_date']));
                    $nestedData['dob'] = date('d-m-Y',strtotime($membershipCard['dob']));
                    $nestedData['ecr'] = $membershipCard['ecr'];
                    $nestedData['country_id'] = $membershipCard['country_details']['name'];
                    $nestedData['status'] = $membershipCard['status'] == '0' ? '<button class="btn btn-danger waves-effect waves-light btn-xs m-b-5">Old Passport</button>' : '<button class="btn btn-success waves-effect waves-light btn-xs m-b-5">New Passport</button>';
                    $nestedData['created_at'] = date('d-m-Y H:i:s',strtotime($membershipCard['created_at']));
                    $nestedData['updated_at'] = date('d-m-Y H:i:s',strtotime($membershipCard['updated_at']));
                    $nestedData['action'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                            &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>
                                            &emsp;<a href='javascript:void(0);' class='delete-btn' data-id='".$membershipCard['id']."'><span class='glyphicon glyphicon-trash'></span>
                                            <form action='".route('airlienList.destroy',$membershipCard['id'])."' method='POST'>
                                                <input type='hidden' name='_method' value='DELETE'>
                                                <input type='hidden' name='_token' value='".csrf_token()."'>
                                            </form></a>";
                    $data[] = $nestedData;
                }
            }

            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
            );

            echo json_encode($json_data); die();
        }
        return view('front-side.membershipcard.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(MembershipCard $membershipCard)
    {
        //
    }

    public function edit(MembershipCard $membershipCard)
    {
        //
    }

    public function update(Request $request, MembershipCard $membershipCard)
    {
        //
    }

    public function destroy(MembershipCard $membershipCard)
    {
        //
    }
}
