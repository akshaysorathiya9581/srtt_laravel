<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use Auth;
use Illuminate\Support\Facades\Redirect;

class ProtectorController extends Controller
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
                $membershipCards = MembershipCard::with(['airlineDetails','clientDetails'])->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get()
                                    ->toArray();
                // dd($membershipCards);
            } else {
                $search = $request->input('search.value');

                $membershipCards =  MembershipCard::with(['airlineDetails','clientDetails'])->where('id','LIKE',"%{$search}%")
                                    ->orWhere('membership_number', 'LIKE',"%{$search}%")
                                    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get()
                                    ->toArray();

                $totalFiltered = MembershipCard::where('id','LIKE',"%{$search}%")
                                    ->orWhere('membership_number', 'LIKE',"%{$search}%")
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
                    $nestedData['airline_name'] = $membershipCard['airline_details']['name'];
                    $nestedData['membership_number'] = $membershipCard['membership_number'];
                    $nestedData['password'] = $membershipCard['password'];
                    $nestedData['email'] = $membershipCard['email'];
                    $nestedData['phone_number'] = $membershipCard['phone_number'];
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
        return view('front-side.protector.index');
    }

    public function create()
    {
        $services = $this->getServicesAllList();
        return view('front-side.protector.create',compact(['services']));
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
