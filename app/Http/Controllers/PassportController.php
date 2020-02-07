<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Traits\CommonTrait;
use Auth;

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
        
        return view('front-side.passport.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countrys = $this->getAllCountry();
        // dd($countrys);
        return view('front-side.passport.create',compact(['countrys']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
