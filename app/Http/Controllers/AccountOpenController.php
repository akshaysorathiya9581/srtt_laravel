<?php

namespace App\Http\Controllers;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;

class AccountOpenController extends Controller
{
    use CommonTrait;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = array(
                0 => 'id',
                1 => 'reference_code',
                2 => 'name',
                3 => 'client_reference',
                4 => 'under',
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
                    $nestedData['name'] = $protector['name'];
                    $nestedData['client_reference'] = strtoupper(implode(',',$services));
                    $nestedData['under'] = $protector['terminal_id'];
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
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
