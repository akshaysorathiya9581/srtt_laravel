<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Traits\CommonTrait;
use App\Passport;
use App\MasterClient;
use App\Http\Requests\PassportRequest;
use Auth;
use Illuminate\Support\Facades\Storage;

class PassportController extends Controller
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

            $totalData = Passport::count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            // echo  $start; die();
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if(empty($request->input('search.value'))) {
                $passports = Passport::with('clientDetails')->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get()
                                    ->toArray();
                // dd($paxprofiles->toArray());
            } else {
                $search = $request->input('search.value');

                $passports =  Passport::with('clientDetails')->where('id','LIKE',"%{$search}%")
                                    ->orWhere('passport_number', 'LIKE',"%{$search}%")
                                    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get()
                                    ->toArray();

                $totalFiltered = Passport::where('id','LIKE',"%{$search}%")
                                    ->orWhere('passport_number', 'LIKE',"%{$search}%")
                                    ->count();
            }
            // dd($passports);
            $data = array();
            if(!empty($passports)){
                foreach ($passports as $passport) {
                    // dd($paxprofile);
                    $show =  route('passport.show',$passport['id']);
                    $edit =  route('passport.edit',$passport['id']);
                    // echo $paxprofile->client_details['f_name']; die();
                    $nestedData['id'] = $passport['id'];
                    $nestedData['name'] = $passport['client_details']['f_name'].' '.$passport['client_details']['m_name'].' '.$passport['client_details']['l_name'];
                    $nestedData['passport_number'] = $passport['passport_number'];
                    $nestedData['issue_date'] = date('d-m-Y',strtotime($passport['issue_date']));
                    $nestedData['issue_place'] = $passport['issue_place'];
                    $nestedData['expiry_date'] = date('d-m-Y',strtotime($passport['expiry_date']));
                    $nestedData['dob'] = date('d-m-Y',strtotime($passport['dob']));
                    $nestedData['ecr'] = $passport['ecr'];
                    $nestedData['country_id'] = $passport['country_id'];
                    $nestedData['status'] = $passport['status'];
                    $nestedData['created_at'] = date('d-m-Y H:i:s',strtotime($passport['created_at']));
                    $nestedData['updated_at'] = date('d-m-Y H:i:s',strtotime($passport['updated_at']));
                    $nestedData['action'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                            &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>
                                            &emsp;<a href='javascript:void(0);' class='delete-btn' data-id='".$passport['id']."'><span class='glyphicon glyphicon-trash'></span>
                                            <form action='".route('airlienList.destroy',$passport['id'])."' method='POST'>
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

        return view('front-side.passport.index');
    }

    public function create()
    {
        $countrys = $this->getAllCountry();
        $clients = MasterClient::all()->toArray();
        // dd($countrys);
        return view('front-side.passport.create',compact(['countrys','clients']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PassportRequest $request)
    {
        $files = $request->file('files');

        $passport = new passport();
        $passport->client_id = $request->client;
        $passport->passport_number = $request->passport_number;
        $passport->issue_date = date('Y-m-d',strtotime($request->issue_date));
        $passport->issue_place = $request->issue_place;
        $passport->expiry_date =date('Y-m-d',strtotime($request->expiry_date));
        $passport->dob =date('Y-m-d',strtotime($request->dob));
        $passport->ecr = $request->ecr;
        $passport->country_id = $request->nationality;
        $passport->created_by = Auth::user()->id;

        if ($request->hasFile('files')) {
            $folder = public_path('passport/' .$passport->id);
            if (!Storage::exists($folder)) {
                Storage::makeDirectory($folder, 777, true, true);
            }
            $imageData = array();
            foreach ($files as $k => $file) {
                $imageName = $file->getFilename().'.'.$file->extension();
                $file->move($folder,$imageName);
                $imageData[] = $imageName;
            }
            $passport->attached = implode(',',$imageData);
            // $imageName = $logo->getFilename().'.'.$logo->extension();
            // $request->logo->move($folder, $imageName);
        }
        $passport->save();
        return Redirect::route('passport.index')->with('message', 'PASSPORT ADD SUCCESSFULLY');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
