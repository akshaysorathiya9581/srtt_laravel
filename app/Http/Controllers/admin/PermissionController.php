<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PermissionRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use Illuminate\Support\Facades\Redirect;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index','store']]);
        $this->middleware('permission:permission-create', ['only' => ['create','store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = array(
                0 =>'id',
                1 =>'name',
                2=> 'created_at',
                3=> 'updated_at',
                4=> 'id',
            );

            $totalData = Role::count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            // echo  $start; die();
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if(empty($request->input('search.value')))
            {
                $permissions = Permission::offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
            }
            else {
                $search = $request->input('search.value');

                $permissions =  Permission::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

                $totalFiltered = Permission::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->count();
            }
            // dd($users);
            $data = array();
            if(!empty($permissions))
            {
                foreach ($permissions as $permission) {
                    $show =  route('permissions.show',$permission->id);
                    $edit =  route('permissions.edit',$permission->id);

                    $nestedData['id'] = $permission->id;
                    $nestedData['name'] = $permission->name;
                    $nestedData['created_at'] = date('d-m-Y H:i:s',strtotime($permission->created_at));
                    $nestedData['updated_at'] = date('d-m-Y H:i:s',strtotime($permission->updated_at));
                    $nestedData['action'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                            &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>
                                            &emsp;<a href='javascript:void(0);' class='delete-btn' data-id='".$permission->id."'><span class='glyphicon glyphicon-trash'></span>
                                            <form action='".route('permissions.destroy',$permission->id)."' method='POST'>
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
        return view('admin-side.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-side.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $permission = Permission::create(['name' => $request->name,'guard_name' => 'web']);

        return Redirect::route('permissions.index')->with('message', 'PERMISSION ADD SUCCESSFULLY');
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
        $data  = Permission::find($id)->toArray();
        return view('admin-side.permission.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id)
    {
        $role = Permission::find($id);
        $role->name = $request->input('name');
        $role->save();

        return Redirect::route('permissions.index')->with('message', 'PERMISSION UPDATE SUCCESSFULLY');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        return Redirect::route('permissions.index')->with('message', 'PERMISSION DELETE SUCCESSFULLY');
    }
}
