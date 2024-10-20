<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Logitem;
use App\User;
use Illuminate\Support\Facades\Auth;
use DataTables;


class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function list_pengajuan()
    {
        $role = auth::user()->role;
        // dd($role);
        return view('customer.list_item',compact('role'));
    }
    public function form_pengembalian()
    {
        $role = auth::user()->role;
        // dd($role);
        return view('customer.form_pengembalian',compact('role'));
    }

    public function api_logpengajuan()
    {
        $id = Auth::user()->id;
        $data = Logitem::where('user_id','=',$id)->get();
        return DataTables::of($data)->make(true);
    }

    public function pengembalian(Request $request)
    {
        try {
            $datapost = $request->all();
            // dd($data);
            $arr = [];
            foreach($datapost as $data => $d){
                // dd($data);
                if($d == null){
                    $datapost[$data] = "yes";
                }
            }
            // return $datapost;
            $datapost["status"] = "A";
            $datapost["user_id"] = auth::user()->id;
            $datapost["tanggal_pengembalian"] = now();
            // return $datapost;
            unset($datapost["_token"]);
            $data = Logitem::create($datapost);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
        
        return response()->json(["status"=>true,"message"=>"Data berhasil disimpan!","data"=>$data]);
    }
}
