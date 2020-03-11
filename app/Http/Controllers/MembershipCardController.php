<?php

namespace App\Http\Controllers;

use App\MembershipCard;
use App\MasterClient;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Http\Requests\MembershipcardRequest;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

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
        return view('front-side.membershipcard.index');
    }

    public function create()
    {
        $airlinelists = $this->getAllAirlineList();
        // dd($airlinelists);
        $clients = MasterClient::all()->toArray();
        return view('front-side.membershipcard.create',compact(['airlinelists','clients']));
    }

    public function store(MembershipcardRequest $request)
    {
        $files = $request->file('files');

        $membershipcard = new MembershipCard();
        $membershipcard->client_id = $request->client;
        $membershipcard->airline_id = $request->airline;
        $membershipcard->membership_number = $request->membership_number;

        if ($request->hasAny(['password', 'email','phone_number','securi_quest','secu_ques_ans','family_program','family_head'])) {
            $membershipcard->password = $request->password;
            $membershipcard->email = $request->email;
            $membershipcard->phone_number =$request->phone_number;
            $membershipcard->securi_quest =$request->securi_quest;
            $membershipcard->secu_ques_ans = $request->secu_ques_ans;
            $membershipcard->family_program = $request->family_program;
            $membershipcard->family_head = $request->family_head;
        }
        $membershipcard->created_by = Auth::user()->id;

        if ($request->hasFile('files')) {
            $folder = public_path('membershipcard/' .$membershipcard->id);
            if (!Storage::exists($folder)) {
                Storage::makeDirectory($folder, 777, true, true);
            }
            $imageData = array();
            foreach ($files as $k => $file) {
                $imageName = $file->getFilename().'.'.$file->extension();
                $file->move($folder,$imageName);
                $imageData[] = $imageName;
            }
            $membershipcard->attached = implode(',',$imageData);
            // $imageName = $logo->getFilename().'.'.$logo->extension();
            // $request->logo->move($folder, $imageName);
        }
        $membershipcard->save();
        return Redirect::route('membershipcard.index')->with('message', 'MEMBERSHIP CARD ADD SUCCESSFULLY');
    }

    public function show($id)
    {
        $membershipCards = MembershipCard::with(['airlineDetails','clientDetails','createdBy','updatedBy'])
                            ->find($id)
                            ->toArray();
        // dd($membershipCards);
        return view('front-side.membershipcard.show',compact(['membershipCards']));
    }

    public function edit($id)
    {
        $airlinelists = $this->getAllAirlineList();
        $clients = MasterClient::all()->toArray();
        $data = MembershipCard::with(['airlineDetails','clientDetails'])->find($id)->toArray();

        return view('front-side.membershipcard.edit',compact(['airlinelists','clients','data']));
    }

    public function update(MembershipcardRequest $request, $id)
    {
        $membershipcard = MembershipCard::find($id);
        $membershipcard->client_id = $request->client;
        $membershipcard->airline_id = $request->airline;
        $membershipcard->membership_number = $request->membership_number;

        if ($request->hasAny(['password', 'email','phone_number','securi_quest','secu_ques_ans','family_program','family_head'])) {
            $membershipcard->password = $request->password;
            $membershipcard->email = $request->email;
            $membershipcard->phone_number =$request->phone_number;
            $membershipcard->securi_quest =$request->securi_quest;
            $membershipcard->secu_ques_ans = $request->secu_ques_ans;
            $membershipcard->family_program = $request->family_program;
            $membershipcard->family_head = $request->family_head;
        }
        $membershipcard->updated_by = Auth::user()->id;

        if ($request->hasFile('files')) {
            $folder = public_path('membershipcard/' .$membershipcard->id);
            if (!Storage::exists($folder)) {
                Storage::makeDirectory($folder, 777, true, true);
            }
            $imageData = array();
            foreach ($files as $k => $file) {
                $imageName = $file->getFilename().'.'.$file->extension();
                $file->move($folder,$imageName);
                $imageData[] = $imageName;
            }
            $membershipcard->attached = implode(',',$imageData);
            // $imageName = $logo->getFilename().'.'.$logo->extension();
            // $request->logo->move($folder, $imageName);
        }
        $membershipcard->save();
        return Redirect::route('membershipcard.index')->with('message', 'MEMBERSHIP CARD UPDATE SUCCESSFULLY');
    }

    public function destroy($id)
    {
        $membershipcard = MembershipCard::find($id);
        $membershipcard->deleted_by = Auth::user()->id;
        $membershipcard->save();

        $membershipcard->delete();
        return Redirect::route('membershipcard.index')->with('message', 'MEMBERSHIP CARD DELETE SUCCESSFULLY');
    }
}
