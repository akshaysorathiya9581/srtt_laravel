<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnderRequest;
use App\Under;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;


class UnderController extends Controller
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

            $totalData = Under::count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            // echo  $start; die();
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if(empty($request->input('search.value'))) {
                $unders = Under::offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get()
                                    ->toArray();
                // dd($membershipCards);
            } else {
                $search = $request->input('search.value');

                $unders =  Under::where('id','LIKE',"%{$search}%")
                                    ->orWhere('membership_number', 'LIKE',"%{$search}%")
                                    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get()
                                    ->toArray();

                $totalFiltered = Under::where('id','LIKE',"%{$search}%")
                                    ->orWhere('membership_number', 'LIKE',"%{$search}%")
                                    ->count();
            }
            // dd($protectors);
            $data = array();
            if(!empty($protectors)){
                foreach ($protectors as $protector) {

                    $show =  route('protector.show',$protector['id']);
                    $edit =  route('protector.edit',$protector['id']);
                    $delete =  route('protector.destroy',$protector['id']);

                    $nestedData['id'] = $protector['id'];
                    $nestedData['reference_code'] = $protector['reference_code'];
                    $nestedData['login_for'] = $protector['login_for'];
                    $nestedData['terminal_id'] = $protector['terminal_id'];
                    $nestedData['name'] = $protector['name'];
                    $nestedData['password'] = $protector['password'];
                    $nestedData['website'] = '<a href="'.$protector['website'].'" target="_blank">'.$protector['website'].'</a>';
                    $nestedData['contact_number'] = $protector['contact_number'];
                    $nestedData['support_name'] = $protector['support_name'];
                    $nestedData['support_number'] = $protector['support_number'];
                    $nestedData['created_at'] = date('d-m-Y H:i:s',strtotime($protector['created_at']));
                    $nestedData['updated_at'] = date('d-m-Y H:i:s',strtotime($protector['updated_at']));
                    $nestedData['action'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                            &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>
                                            &emsp;<a href='javascript:void(0);' class='delete-btn' data-id='".$protector['id']."'><span class='glyphicon glyphicon-trash'></span>
                                            <form action='".$delete."' method='POST'>
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
        return view('admin-side.under.index');
    }

    public function create()
    {
        return view('admin-side.under.create');
    }

    public function store(UnderRequest $request)
    {
        $under = new Under();
        $under->name = strtoupper($request->name);
        $under->created_by = Auth::user()->id;
        $under->save();

        if($under->id > 0) {
            $this->generateReferenceCode('unders',$under->id);
            return Redirect::route('unders.index')->with('message', 'UNDER ADD SUCCESSFULLY');
        }

    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $data = Under::find($id);
        return view('admin-side.under.edit',compact(['data']));
    }

    public function update(Request $request, $id)
    {
        $under = Under::find($id);
        $under->name =strtoupper($request->name);
        $under->created_by = Auth::user()->id;
        $under->save();
        return Redirect::route('under.index')->with('message', 'UNDER UPDATE SUCCESSFULLY');
    }

    public function destroy($id)
    {
        $under = Under::find($id);
        $under->deleted_by = Auth::user()->id;
        $under->save();

        $under->delete();
        return Redirect::route('under.index')->with('message', 'UNDER DELETE SUCCESSFULLY');
    }
}
