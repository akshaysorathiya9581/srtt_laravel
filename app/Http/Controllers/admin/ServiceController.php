<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ServicesRequest;
use App\Traits\CommonTrait;
use Illuminate\Support\Facades\Redirect;
use App\Service;
use Auth;

class ServiceController extends Controller
{
    use CommonTrait;

    function __construct()
    {
        $this->middleware('permission:service-list|service-create|service-edit|service-delete', ['only' => ['index','store']]);
        $this->middleware('permission:service-create', ['only' => ['create','store']]);
        $this->middleware('permission:service-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:service-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = array(
                0   =>  'id',
                1   =>  'name',
                2   =>  'created_at',
                3   =>  'updated_at',
                4   =>  'id',
            );

            $totalData = Service::count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            // echo  $start; die();
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if(empty($request->input('search.value')))
            {
                $services = Service::offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
            }
            else {
                $search = $request->input('search.value');

                $services =  Service::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

                $totalFiltered = Service::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->count();
            }
            // dd($services);
            $data = array();
            if(!empty($services))
            {
                foreach ($services as $service) {
                    $show =  route('services.show',$service->id);
                    $edit =  route('services.edit',$service->id);

                    $nestedData['id']   = $service->id;
                    $nestedData['reference_code'] = $service->reference_code;
                    $nestedData['name'] = $service->name;
                    $nestedData['created_at'] = date('d-m-Y H:i:s',strtotime($service->created_at));
                    $nestedData['updated_at'] = date('d-m-Y H:i:s',strtotime($service->updated_at));
                    $nestedData['action'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                            &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>
                                            &emsp;<a href='javascript:void(0);' class='delete-btn' data-id='".$service->id."'><span class='glyphicon glyphicon-trash'></span>
                                            <form action='".route('services.destroy',$service->id)."' method='POST'>
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
        return view('admin-side.services.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-side.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServicesRequest $request)
    {
        $services = Service::create(['name' => $request->name,'created_by' => Auth::user()->id]);
        $this->generateReferenceCode('services',$services->id);

        return Redirect::route('services.index')->with('message', 'SERVICE ADD SUCCESSFULLY');
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
        $service = Service::find($id);
        return view('admin-side.services.edit',compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServicesRequest $request, $id)
    {
        $service = Service::find($id);
        $service->name = $request->input('name');
        $service->save();

        return redirect()->route('services.index')->with('message','Service Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id);
        $service->deleted_by = Auth::user()->id;
        $service->save();
        
        $service->delete();
        return Redirect::route('services.index')->with('message', 'SERVICE DELETE SUCCESSFULLY');
    }
}
