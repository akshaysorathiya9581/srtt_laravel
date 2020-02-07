<?php
namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Redirect;
use DB;


class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
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

            if(empty($request->input('search.value'))) {
                $roles = Role::offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
            } else {
                $search = $request->input('search.value');

                $roles =  Role::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

                $totalFiltered = Role::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->count();
            }
            // dd($roles);
            $data = array();
            if(!empty($roles))
            {
                foreach ($roles as $role) {
                    $show =  route('roles.show',$role->id);
                    $edit =  route('roles.edit',$role->id);

                    $nestedData['id'] = $role->id;
                    $nestedData['name'] = $role->name;
                    $nestedData['created_at'] = date('d-m-Y H:i:s',strtotime($role->created_at));
                    $nestedData['updated_at'] = date('d-m-Y H:i:s',strtotime($role->updated_at));
                    $nestedData['action'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                            &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>
                                            &emsp;<a href='javascript:void(0);' class='delete-btn' data-id='".$role->id."'><span class='glyphicon glyphicon-trash'></span>
                                            <form action='".route('roles.destroy',$role->id)."' method='POST'>
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
        return view('admin-side.roles.index');
        // $roles = Role::orderBy('id','DESC')->paginate(5);
        // return view('roles.index',compact('roles'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('admin-side.roles.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        // $role->syncPermissions($request->input('permission'));

        return Redirect::route('roles.index')->with('message', 'ROLE ADD SUCCESSFULLY');
    }

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();


        return view('admin-side.roles.show',compact('role','rolePermissions'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        return view('admin-side.roles.edit',compact('role'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);


        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();


        // $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }
}
