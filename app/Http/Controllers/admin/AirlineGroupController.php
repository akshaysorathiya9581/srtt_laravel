<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\airlineGroupRequest;
use App\AirlineGroup;
use Auth;
use Illuminate\Support\Facades\Redirect;
use DataTables;

class AirlineGroupController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:airlinegroup-list|airlinegroup-create|airlinegroup-edit|airlinegroup-delete', ['only' => ['index','store']]);
        $this->middleware('permission:airlinegroup-create', ['only' => ['create','store']]);
        $this->middleware('permission:airlinegroup-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:airlinegroup-delete', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            //         $query=AirlineGroup::get();

            //         return Datatables::collection($query)
            //         ->addColumn('id', function ($query) {
            //             return $query->id;
            //         })->addColumn('name', function ($query) {
            //             return $query->name;
            //         })->addColumn('created_at', function ($query) {
            //             return $query->created_at;
            //         })->addColumn('updated_at', function ($query) {
            //             return $query->updated_at;
            //         })->addColumn('action', function ($query) {
            //             $btn = '<a href="#" class="table-action-btn h3"><i class="mdi mdi-pencil-box-outline text-success"></i></a><a href="#" class="table-action-btn h3"><i class="mdi mdi-close-box-outline text-danger"></i></a><a href="javascript:void(0)" class="table-action-btn h3"><i class="mdi mdi-eye text-primary"></i></a>';
            //             return $btn;
            //         })->make(true);
        

            $columns = array( 
                0 =>'id', 
                1 =>'name',
                2=> 'created_at',
                3=> 'updated_at',
                4=> 'id',
            );

            $totalData = AirlineGroup::count();

            $totalFiltered = $totalData; 

            $limit = $request->input('length');
            $start = $request->input('start');
            // echo  $start; die();
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if(empty($request->input('search.value')))
            {            
                $posts = AirlineGroup::offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)   
                        ->get();
            }
            else {
                $search = $request->input('search.value'); 

                $posts =  AirlineGroup::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

                $totalFiltered = AirlineGroup::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->count();
            }
            // dd($posts);
            $data = array();
            if(!empty($posts))
            {
                foreach ($posts as $post) {
                    $show =  route('airlineGroup.show',$post->id);
                    $edit =  route('airlineGroup.edit',$post->id);

                    $nestedData['id'] = $post->id;
                    $nestedData['name'] = $post->name;
                    $nestedData['created_at'] = date('d-m-Y H:i:s',strtotime($post->created_at));
                    $nestedData['updated_at'] = date('d-m-Y H:i:s',strtotime($post->updated_at));
                    $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                            &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>
                                            &emsp;<a href='javascript:void(0);' class='delete-btn' data-id='".$post->id."'><span class='glyphicon glyphicon-trash'></span>
                                            <form action='".route('airlineGroup.destroy',$post->id)."' method='POST'>
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
        return view('admin-side.airline-group.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('admin-side.airline-group.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(airlineGroupRequest $request)
    {
        $AirlineGroup = AirlineGroup::create(['name' => $request->name,'created_by' => Auth::user()->id]);

        return Redirect::route('airlineGroup.index')->with('message', 'GROUP ADD SUCCESSFULLY');
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
        $data  = AirlineGroup::find($id)->toArray();
        // dd($data);
        return view('admin-side.airline-group.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(airlineGroupRequest $request, $id)
    {
        $AirlineGroup = AirlineGroup::find($id);
        $AirlineGroup->name =  $request->name;
        $AirlineGroup->updated_by = Auth::user()->id;
        $AirlineGroup->save();

        return Redirect::route('airlineGroup.index')->with('message', 'GROUP UPDATE SUCCESSFULLY');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $AirlineGroup = AirlineGroup::find($id);
        $AirlineGroup->delete();

        // redirect
        return Redirect::route('airlineGroup.index')->with('message', 'GROUP DELETE SUCCESSFULLY');
    }
}
