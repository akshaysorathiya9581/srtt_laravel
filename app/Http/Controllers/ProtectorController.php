<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CommonTrait;
use App\Protector;
use App\Http\Requests\ProtectorRequest;
use Auth;
use Illuminate\Support\Facades\Redirect;
use App\Service;

class ProtectorController extends Controller
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

            $totalData = Protector::count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            // echo  $start; die();
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if(empty($request->input('search.value'))) {
                $protectors = Protector::offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get()
                                    ->toArray();
                // dd($membershipCards);
            } else {
                $search = $request->input('search.value');

                $protectors =  Protector::where('id','LIKE',"%{$search}%")
                                    ->orWhere('membership_number', 'LIKE',"%{$search}%")
                                    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get()
                                    ->toArray();

                $totalFiltered = Protector::where('id','LIKE',"%{$search}%")
                                    ->orWhere('membership_number', 'LIKE',"%{$search}%")
                                    ->count();
            }
            // dd($protectors);
            $data = array();
            if(!empty($protectors)){
                foreach ($protectors as $protector) {
                    $services = Service::whereIn('id', explode(',', $protector['service_id']))->pluck('name')->toArray();
                    // dd($services);
                    $show =  route('protector.show',$protector['id']);
                    $edit =  route('protector.edit',$protector['id']);
                    $delete =  route('protector.destroy',$protector['id']);

                    $nestedData['id'] = $protector['id'];
                    $nestedData['reference_code'] = $protector['reference_code'];
                    $nestedData['login_for'] = $protector['login_for'];
                    $nestedData['service'] = strtoupper(implode(',',$services));
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
        return view('front-side.protector.index');
    }

    public function create()
    {
        $services = $this->getServicesAllList();
        return view('front-side.protector.create',compact(['services']));
    }

    public function store(ProtectorRequest $request)
    {
        // dd($request->all());
        $protector = new Protector();
        $protector->login_for = strtoupper($request->login_for);
        $protector->service_id = implode(',',$request->service);
        $protector->terminal_id =$request->terminal_id;
        $protector->name = $request->name;
        $protector->password =$request->password;
        $protector->website =$request->website;
        $protector->contact_number = $request->contact_number;
        $protector->support_name = $request->support_name;
        $protector->support_number = $request->support_number;
        $protector->created_by = Auth::user()->id;
        $protector->save();

        if($protector->id > 0) {
            $this->generateReferenceCode('protectors',$protector->id);
            return Redirect::route('protector.index')->with('message', 'PROTECTOR ADD SUCCESSFULLY');
        }

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = Protector::find($id)->toArray();
        $services = $this->getServicesAllList();
        return view('front-side.protector.edit',compact(['data','services']));
    }

    public function update(ProtectorRequest $request, $id)
    {
        $protector = Protector::find($id);
        $protector->login_for = strtoupper($request->login_for);
        $protector->service_id = implode(',',$request->service);
        $protector->terminal_id =$request->terminal_id;
        $protector->name = $request->name;
        $protector->password =$request->password;
        $protector->website =$request->website;
        $protector->contact_number = $request->contact_number;
        $protector->support_name = $request->support_name;
        $protector->support_number = $request->support_number;
        $protector->updated_by = Auth::user()->id;
        $protector->save();

        return Redirect::route('protector.index')->with('message', 'PROTECTOR UPDATE SUCCESSFULLY');
    }

    public function destroy($id)
    {
        $protector = Protector::find($id);
        $protector->deleted_by = Auth::user()->id;
        $protector->save();

        $protector->delete();
        return Redirect::route('protector.index')->with('message', 'PROTECTOR DELETE SUCCESSFULLY');
    }
}
