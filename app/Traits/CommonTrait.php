<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait CommonTrait {

    public function generateReferenceCode($table,$id)
    {
    	$insert_id = DB::table('reference_code')->insertGetId(['year' => date('Y')]);
    	$totRef = DB::table('reference_code')->where('year', date('Y'))->count();
    	DB::table($table)->where('id', $id)->update(['reference_code' => $totRef.'/'.date('Y'),'ref_id' => $insert_id]);

        return $totRef.'/'.date('Y');
    }

    public function getAllCountry()
    {
    	return  DB::table('countries')->get()->toArray();
    }
    public function getAllAirlineList()
    {
    	return  DB::table('airlinelists')->get()->toArray();
    }
}
?>
