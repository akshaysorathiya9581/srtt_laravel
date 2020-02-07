<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Redirect;
use DB;
use Hash;
use response;


class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = array(
                0 =>'id',
                1 =>'name',
                2 =>'email',
                3 =>'roles',
                4=> 'created_at',
                5=> 'updated_at',
                6=> 'id',
            );

            $totalData = User::count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            // echo  $start; die();
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if(empty($request->input('search.value')))
            {
                $users = User::offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
            }
            else {
                $search = $request->input('search.value');

                $users =  User::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

                $totalFiltered = User::where('id','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->count();
            }
            // dd($users);
            $data = array();
            if(!empty($users))
            {
                foreach ($users as $user) {
                    $show =  route('users.show',$user->id);
                    $edit =  route('users.edit',$user->id);

                    $nestedData['id'] = $user->id;
                    $nestedData['name'] = $user->name;
                    $nestedData['email'] = $user->email;
                    $nestedData['created_at'] = date('d-m-Y H:i:s',strtotime($user->created_at));
                    $nestedData['updated_at'] = date('d-m-Y H:i:s',strtotime($user->updated_at));
                    $nestedData['action'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                            &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>
                                            &emsp;<a href='javascript:void(0);' class='delete-btn' data-id='".$user->id."'><span class='glyphicon glyphicon-trash'></span>
                                            <form action='".route('users.destroy',$user->id)."' method='POST'>
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
        return view('admin-side.users.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $permission = Permission::get();
        return view('admin-side.users.create',compact(['roles','permission']));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);


        // $input = $request->all();
        // $input['password'] = Hash::make($input['password']);
        // $role_permissions = Role::with('permissions')->get()->toArray();

        // dd($role_permissions);
        $user = User::create(
            [
              'name' => $request->name,
              'email' => $request->email,
              'password' => Hash::make($request->password),
              'role' => $request->roles,
            ]
        );
        $user->syncPermissions($request->input('permission'));
        // $user->givePermissionTo($request->input('permission'));
        // $user->assignRole($request->input('roles'));


        return Redirect::route('users.index')->with('message', 'USER ADD SUCCESSFULLY');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        // dd($user);
        $roles = Role::all();
        $permissions = Permission::all();
        $getApplyPermission = $user->getDirectPermissions()->pluck('id')->toArray();
        // dd($getApplyPermission);
        return view('admin-side.users.edit',compact('user','roles','getApplyPermission','permissions'));
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

       
       // dd($request->permission);
        $userData = array(
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->roles
        );
        if(!empty($input['password'])){
            $userData['password'] = Hash::make($input['password']);
        } 

        $user = User::find($id);
        $user->update($userData);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $role = $request->input('role');
        $permissions = $request->permission;
      
        $user->syncPermissions($permissions);
        // $user->assignRole($role);
        return Redirect::route('users.index')->with('message', 'USER UPDATE SUCCESSFULLY');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return Redirect::route('users.index')->with('message', 'USER DELETE SUCCESSFULLY');
    }

    public function getRolePermission(Request $request)
    {   
        if ($request->ajax()) {
          // $role_permissions = Role::with(['permissions' => function($permissions) use ($request) {
          //                       $permissions->where('role_id','=',$request->id);
          //                   }])->get()->toArray();
            // $role_permissions = Role::with(['permissions'])->where('id',$request->id)->get()->first()->toArray();  
          $role_permissions = Permission::all()->toArray();
            // dd($role_permissions);
           return response()->json(['data' => $role_permissions]);
        }
    }
}
