<?php

namespace App\Http\Controllers;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Auth;
use App\Accountopen;
use App\Under;
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

            $totalData = Accountopen::count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            // echo  $start; die();
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if(empty($request->input('search.value'))) {
                $accountopens = Accountopen::offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get()
                                    ->toArray();
                // dd($membershipCards);
            } else {
                $search = $request->input('search.value');

                $accountopens =  Accountopen::where('id','LIKE',"%{$search}%")
                                    ->orWhere('name', 'LIKE',"%{$search}%")
                                    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get()
                                    ->toArray();

                $totalFiltered = Accountopen::where('id','LIKE',"%{$search}%")
                                    ->orWhere('name', 'LIKE',"%{$search}%")
                                    ->count();
            }
            // dd($protectors);
            $data = array();
            if(!empty($accountopens)){
                foreach ($accountopens as $accountopen) {
                    $show =  route('accountopen.show',$accountopen['id']);
                    $edit =  route('accountopen.edit',$accountopen['id']);
                    $delete =  route('accountopen.destroy',$accountopen['id']);

                    $nestedData['id'] = $accountopen['id'];
                    $nestedData['reference_code'] = $accountopen['reference_code'];
                    $nestedData['name'] = $accountopen['name'];
                    $nestedData['client_reference'] = $accountopen['client_reference'];
                    $nestedData['under'] = $accountopen['under'];
                    $nestedData['created_at'] = date('d-m-Y H:i:s',strtotime($accountopen['created_at']));
                    $nestedData['updated_at'] = date('d-m-Y H:i:s',strtotime($accountopen['updated_at']));
                    $nestedData['action'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                            &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>
                                            &emsp;<a href='javascript:void(0);' class='delete-btn' data-id='".$accountopen['id']."'><span class='glyphicon glyphicon-trash'></span>
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
        return view('front-side.accountopen.index');
    }

    public function create()
    {
        $unders = Under::all()->toArray();
        return view('front-side.accountopen.create',compact(['unders']));
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
