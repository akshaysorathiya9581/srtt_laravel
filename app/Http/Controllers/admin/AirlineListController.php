<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AirlinelistRequest;
use App\Airlinelist;
use App\AirlineGroup;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class AirlineListController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:airlinelist-list|airlinelist-create|airlinelist-edit|airlinelist-delete', ['only' => ['index','store']]);
        $this->middleware('permission:airlinelist-create', ['only' => ['create','store']]);
        $this->middleware('permission:airlinelist-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:airlinelist-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = array(
                0 =>'id',
                1 =>'image',
                2 =>'name',
                3 =>'membership_plan',
                4 =>'airline_group',
                5 =>'airline_gst',
                6 => 'created_at',
                7 => 'updated_at',
                8 => 'id',
            );

            $totalData = Airlinelist::count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            // echo  $start; die();
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if(empty($request->input('search.value'))) {
                $airlinelists = Airlinelist::with('airlineGroup')->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
                // dd($airlinelists);
            } else {
                $search = $request->input('search.value');

                $airlinelists =  Airlinelist::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

                $totalFiltered = Airlinelist::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->count();
            }
            // dd($airlinelists);
            $data = array();
            if(!empty($airlinelists)){
                foreach ($airlinelists as $airlinelist) {
                    $show =  route('airlienList.show',$airlinelist->id);
                    $edit =  route('airlienList.edit',$airlinelist->id);

                    $nestedData['id'] = $airlinelist->id;
                    $nestedData['image'] = '<img src="'.asset('public/airlineLogo/'.$airlinelist->id.'/'.$airlinelist->image).'" class="img-responsive thumb-md">';
                    $nestedData['name'] = $airlinelist->name;
                    $nestedData['membership_plan'] = $airlinelist->membership_plan;
                    $nestedData['airline_group'] = $airlinelist->airlineGroup->name;
                    $nestedData['airline_gst'] = $airlinelist->airline_gst == '1' ? 'FROM WEBSITE' : 'FROM AIRLINE';
                    $nestedData['created_at'] = date('d-m-Y H:i:s',strtotime($airlinelist->created_at));
                    $nestedData['updated_at'] = date('d-m-Y H:i:s',strtotime($airlinelist->updated_at));
                    $nestedData['action'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                            &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>
                                            &emsp;<a href='javascript:void(0);' class='delete-btn' data-id='".$airlinelist->id."'><span class='glyphicon glyphicon-trash'></span>
                                            <form action='".route('airlienList.destroy',$airlinelist->id)."' method='POST'>
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

        // dd($AirlineGroups);
       return view('admin-side.airline-list.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $airlineGroups = AirlineGroup::all()->toArray();
        return view('admin-side.airline-list.create',compact('airlineGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AirlinelistRequest $request)
    {
        // dd($request->all());
        $logo = $request->file('logo');

        $airlinelist = new Airlinelist();
        $airlinelist->name = $request->name;
        $airlinelist->membership_plan = $request->membership_plan;
        $airlinelist->airline_group_id = $request->airline_group;
        $airlinelist->airline_gst = $request->airline_gst;
        $airlinelist->email = $request->email;
        $airlinelist->phone_number = $request->phone_number;
        $airlinelist->contact_person = $request->contact_person;
        $airlinelist->url = $request->url;
        $airlinelist->image =  $logo->getFilename().'.'.$logo->extension();
        $airlinelist->created_by = Auth::user()->id;
        $airlinelist->save();

        if ($request->hasFile('logo')) {
            $folder = public_path('airlineLogo/' .$airlinelist->id);
            if (!Storage::exists($folder)) {
                Storage::makeDirectory($folder, 777, true, true);
            }
            $imageName = $logo->getFilename().'.'.$logo->extension();
            $request->logo->move($folder, $imageName);
        }
        return Redirect::route('airlienList.index')->with('message', 'AIRLINE ADD SUCCESSFULLY');
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
        $airlineGroups = AirlineGroup::all()->toArray();
        $airlinelist = Airlinelist::find($id)->toArray();
        return view('admin-side.airline-list.edit',compact(['airlineGroups','airlinelist']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AirlinelistRequest $request, $id)
    {
        // dd($request->all());
        $logo = $request->file('logo');

        $airlinelist = Airlinelist::find($id);
        $airlinelist->name = $request->name;
        $airlinelist->membership_plan = $request->membership_plan;
        $airlinelist->airline_group_id = $request->airline_group;
        $airlinelist->airline_gst = $request->airline_gst;

        if($request->has('email')){
            $airlinelist->email = $request->email;
        }

        if($request->has('phone_number')) {
            $airlinelist->phone_number = $request->phone_number;
        }

        if($request->has('contact_person')) {
            $airlinelist->contact_person = $request->contact_person;
        }

        if($request->has('url')) {
            $airlinelist->url = $request->url;
        }

        if ($request->hasFile('logo')) {
            $airlinelist->image =  $logo->getFilename().'.'.$logo->extension();
        }
        $airlinelist->updated_by = Auth::user()->id;
        $airlinelist->save();

        if ($request->hasFile('logo')) {
            $folder = public_path('airlineLogo/' .$airlinelist->id);
            if (!Storage::exists($folder)) {
                Storage::makeDirectory($folder, 777, true, true);
            }
            $imageName = $logo->getFilename().'.'.$logo->extension();
            $request->logo->move($folder, $imageName);
        }
        return Redirect::route('airlienList.index')->with('message', 'AIRLINE UPDATE SUCCESSFULLY');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $airlinelist = Airlinelist::find($id);
        $airlinelist->deleted_by = Auth::user()->id;
        $airlinelist->save();

        $airlinelist->delete();
        return Redirect::route('airlienList.index')->with('message', 'AIRLINE DELETE SUCCESSFULLY');
    }
}
