<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\MealPreference;
use App\SeatPreference;
use App\MasterClient;
use App\MasterClientSuggestion;
use App\PaxProfile;
use Illuminate\Support\Facades\Redirect;
use App\Traits\CommonTrait;
use Auth;

class PaxProfileController extends Controller
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

            $totalData = PaxProfile::count();

            $totalFiltered = $totalData; 

            $limit = $request->input('length');
            $start = $request->input('start');
            // echo  $start; die();
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if(empty($request->input('search.value'))) {            
                $paxprofiles = PaxProfile::with('clientDetails')->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)   
                                    ->get()
                                    ->toArray();
                // dd($paxprofiles->toArray());
            } else {
                $search = $request->input('search.value'); 

                $paxprofiles =  Airlinelist::with('clientDetails')->where('id','LIKE',"%{$search}%")
                                    ->orWhere('name', 'LIKE',"%{$search}%")
                                    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get();
                                    dd($paxprofiles);

                $totalFiltered = Airlinelist::where('id','LIKE',"%{$search}%")
                                    ->orWhere('name', 'LIKE',"%{$search}%")
                                    ->count();
            }
            // dd($airlinelists);
            $data = array();
            if(!empty($paxprofiles)){
                foreach ($paxprofiles as $paxprofile) {
                    // dd($paxprofile);
                    $show =  route('paxprofile.show',$paxprofile['id']);
                    $edit =  route('paxprofile.edit',$paxprofile['id']);
                    // echo $paxprofile->client_details['f_name']; die();
                    $nestedData['id'] = $paxprofile['id'];
                    $nestedData['reference_code'] = $paxprofile['reference_code'];
                    $nestedData['name'] = $paxprofile['client_details']['f_name'].' '.$paxprofile['client_details']['m_name'].' '.$paxprofile['client_details']['l_name'];
                    $nestedData['place'] = $paxprofile['client_details']['place'];
                    $nestedData['dob'] = date('d-m-Y',strtotime($paxprofile['client_details']['dob']));
                    $nestedData['created_at'] = date('d-m-Y H:i:s',strtotime($paxprofile['created_at']));
                    $nestedData['updated_at'] = date('d-m-Y H:i:s',strtotime($paxprofile['updated_at']));
                    $nestedData['action'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                            &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>
                                            &emsp;<a href='javascript:void(0);' class='delete-btn' data-id='".$paxprofile['id']."'><span class='glyphicon glyphicon-trash'></span>
                                            <form action='".route('airlienList.destroy',$paxprofile['id'])."' method='POST'>
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
        
        return view('front-side.paxprofile.index');
    }

    public function create()
    {
        $mealPreferences = MealPreference::all()->toArray();
        $seatPreferences = SeatPreference::all()->toArray();
        $countrys = $this->getAllCountry();
        // dd($countrys);
        return view('front-side.paxprofile.create',compact(['mealPreferences','seatPreferences','countrys']));
    }

    public function store(Request $request)
    {
        $f_name = $request->f_name;
        $l_name = $request->l_name;
        $dob = $request->dob;

        $validationRule = [
            'f_name' => 'required',
            'l_name'=> 'required',
            'dob' => 'required',
            'place' => 'required',
            'email' => 'required',
            'phone_coun_code' => 'required',
            'phone_number' => 'required',
            'whatsapp_coun_code' => 'required',
            'whatsapp_number' => 'required',
        ];

        $validationMsg = [
            'f_name.required' => 'First Name is required', 
            'l_name.required' => 'Last Name is required',
            'dob.required' => 'Date of Birth is required',
            'place.required' => 'Place is required',
            'email.required' => 'Email is required',
            'phone_coun_code.required' => 'Country Code is required',
            'phone_number.required' => 'Phone number is required',
            'whatsapp_coun_code.required' => 'Country is required',
            'whatsapp_number.required' => 'Whatsapp number is required',
        ];

        $validation = Validator::make(
            [
                'f_name' => $f_name, 
                'l_name' => $l_name,
                'dob' => $dob,
                'place' => $request->place,
                'email' => $request->email,
                'phone_coun_code' => $request->phone_coun_code,
                'phone_number' => $request->phone_number,
                'whatsapp_coun_code' => $request->whatsapp_coun_code,
                'whatsapp_number' => $request->whatsapp_number,
            ], $validationRule, $validationMsg);

        $validation->after(function ($validation) use ($f_name, $l_name, $dob) {
            $checkName = MasterClient::where('f_name', $f_name)->where('l_name', $l_name)->where('dob',date('Y-m-d',strtotime($dob)))->get();
            if (count($checkName) > 0) {
                $validation->errors()->add('f_name', 'User already exists, please enter another user.');
            }
        });
       
        if ($validation->fails()) {
            foreach ($validation->errors()->all() as $error) {
                $message = $error;
            }
            return Redirect::route('paxprofile.create')->withErrors($validation)->withInput();
        } else {
           $masterClient  = MasterClient::updateOrCreate(
                ['f_name' => $f_name, 'l_name' => $l_name,'dob' => date('Y-m-d',strtotime($dob))],
                ['f_name' => $f_name, 'l_name' => $l_name, 'm_name' => $request->m_name,'dob' => date('Y-m-d',strtotime($dob)),'place'=> $request->place,'gender' => $request->gender]
            ); 

           $masterClientSuggestion = MasterClientSuggestion::updateOrCreate(
                ['client_id' => $masterClient->id, 'cont_coun_code' => $request->phone_coun_code,'phone_number' => $request->phone_number,'whas_coun_code' => $request->whatsapp_coun_code,'wtsapp_no' => $request->whatsapp_number,'email' => $request->email],
                ['client_id' => $masterClient->id, 'cont_coun_code' => $request->phone_coun_code,'phone_number' => $request->phone_number,'whas_coun_code' => $request->whatsapp_coun_code,'wtsapp_no' => $request->whatsapp_number,'email' => $request->email]
            );

            $paxprofile = PaxProfile::create(['client_id' => $masterClient->id,'meal_preference' => $request->meal_pre,'seat_preference' => $request->seat_pre,'created_by' => Auth::user()->id]);
            $this->generateReferenceCode('pax_profiles',$paxprofile->id);
            return Redirect::route('paxprofile.index')->with('message', 'paxprofile ADD SUCCESSFULLY');
        }
        
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = PaxProfile::with(['clientDetails','author.publishers'])->find($id)->toArray();
        // dd($data);
        $mealPreferences = MealPreference::all()->toArray();
        $seatPreferences = SeatPreference::all()->toArray();
        $countrys = $this->getAllCountry();
        return view('front-side.paxprofile.edit',compact(['mealPreferences','seatPreferences','countrys','data']));
    }

    public function update(Request $request, $id)
    {
        $paxprofile = PaxProfile::find($id);

        $f_name = $request->f_name;
        $l_name = $request->l_name;
        $dob = $request->dob;

        $validationRule = [
            'f_name' => 'required',
            'l_name'=> 'required',
            'dob' => 'required',
            'place' => 'required',
            'email' => 'required',
            'phone_coun_code' => 'required',
            'phone_number' => 'required',
            'whatsapp_coun_code' => 'required',
            'whatsapp_number' => 'required',
        ];

        $validationMsg = [
            'f_name.required' => 'First Name is required', 
            'l_name.required' => 'Last Name is required',
            'dob.required' => 'Date of Birth is required',
            'place.required' => 'Place is required',
            'email.required' => 'Email is required',
            'phone_coun_code.required' => 'Country Code is required',
            'phone_number.required' => 'Phone number is required',
            'whatsapp_coun_code.required' => 'Country is required',
            'whatsapp_number.required' => 'Whatsapp number is required',
        ];

        $validation = Validator::make(
            [
                'f_name' => $f_name, 
                'l_name' => $l_name,
                'dob' => $dob,
                'place' => $request->place,
                'email' => $request->email,
                'phone_coun_code' => $request->phone_coun_code,
                'phone_number' => $request->phone_number,
                'whatsapp_coun_code' => $request->whatsapp_coun_code,
                'whatsapp_number' => $request->whatsapp_number,
            ], $validationRule, $validationMsg);

        $validation->after(function ($validation) use ($f_name, $l_name, $dob) {
            $checkName = MasterClient::where('f_name', $f_name)->where('l_name', $l_name)->where('dob',date('Y-m-d',strtotime($dob)))->where('id !=', $paxprofile->client_id)->get();
            if (count($checkName) > 0) {
                $validation->errors()->add('f_name', 'User already exists, please enter another user.');
            }
        });
       
        if ($validation->fails()) {
            foreach ($validation->errors()->all() as $error) {
                $message = $error;
            }
            return Redirect::route('paxprofile.create')->withErrors($validation)->withInput();
        } else {
           $masterClient  = MasterClient::updateOrCreate(
                ['f_name' => $f_name, 'l_name' => $l_name,'dob' => date('Y-m-d',strtotime($dob))],
                ['f_name' => $f_name, 'l_name' => $l_name, 'm_name' => $request->m_name,'dob' => date('Y-m-d',strtotime($dob)),'place'=> $request->place,'gender' => $request->gender]
            ); 

           $masterClientSuggestion = MasterClientSuggestion::updateOrCreate(
                ['client_id' => $masterClient->id, 'cont_coun_code' => $request->phone_coun_code,'phone_number' => $request->phone_number,'whas_coun_code' => $request->whatsapp_coun_code,'wtsapp_no' => $request->whatsapp_number,'email' => $request->email],
                ['client_id' => $masterClient->id, 'cont_coun_code' => $request->phone_coun_code,'phone_number' => $request->phone_number,'whas_coun_code' => $request->whatsapp_coun_code,'wtsapp_no' => $request->whatsapp_number,'email' => $request->email]
            );

            $paxprofile->client_id = $masterClient->id;
            $paxprofile->meal_preference = $request->meal_pre;
            $paxprofile->seat_preference = $request->seat_pre;
            $paxprofile->updated_by = Auth::user()->id;

            $paxprofile->update($paxprofile);
            
            return Redirect::route('paxprofile.index')->with('message', 'PAXPROFILE ADD SUCCESSFULLY');
        }
    }

    public function destroy($id)
    {
        //
    }
}
