<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\Logitem;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LogitemExport;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function dashboard_admin()
    {
        $role = Auth::user()->role_id;
        return view('admin.dashboard_admin',compact('role'));
    }
    public function list_user()
    {
        $role = Auth::user()->role_id;
        return view('admin.list_user',compact('role'));
    }
    public function list_item()
    {
        $role = Auth::user()->role_id;
        return view('admin.list_item',compact('role'));
    }
    public function api_user()
    {
        $data = User::all();
        return DataTables::of($data)->make(true);
    }
    public function api_logitem()
    {
        $data = Logitem::all();
        return DataTables::of($data)->make(true);
    }
    public function reset_password($id)
    {
        try {
            $data = User::find($id);
            $data->update([
                'password' => Hash::make('1112')
            ]);
            return response()->json(["status"=>true,"message"=>"data berhasil diupdate!","data"=>$data],200);
        } catch (\Throwable $th) {
            return response()->json(["status"=>false,"message"=>$th->getMessage()],500);
        }
        return DataTables::of($data)->make(true);
    }

    public function aktivasi($id)
    {
        try {
            $data = User::find($id);
            $status = $data->is_active;
            if($status == 1)$status = 0;
            else $status=1;
            $data->update([
                'is_active' => $status
            ]);
            return response()->json(["status"=>true,"message"=>"data berhasil diupdate!","data"=>$data],200);
        } catch (\Throwable $th) {
            return response()->json(["status"=>false,"message"=>$th->getMessage()],500);
        }
        return DataTables::of($data)->make(true);
    }
    
    public function list_logitem()
    {
        $role = Auth::user()->role_id;
        return view('admin.list_item',compact('role'));
    }
    public function detailitem($id)
    {
        $data = Logitem::where('log_item.id',$id)
        ->join('users as u','log_item.user_id','=','u.id')->first();
        // dd($data);
        return response()->json(["status"=>true,"message"=>"Data detail berhasil ditemukan!","data"=>$data]);
    }
    public function actionitem(Request $request, $id,$status)
    {
        $data = Logitem::find($id);
        
        // dd($imageName);
        $data->update([
            'status' => $status,
            'tanggal_approval' => now(),
        ]);
        
        // dd($data);
        return response()->json(["status"=>true,"message"=>"Data berhasil diupdate!","data"=>$data]);
    }
    public function api_dashboard()
    {
        $dataA = Logitem::where('status','=','A')->count();
        $dataB = Logitem::where('status','=','B')->count();
        $dataC = Logitem::where('status','=','C')->count();
        $dataUser = User::count();
        // dd($data);
        $data = [
            "dataA"=>$dataA,
            "dataB"=>$dataB,
            "dataC"=>$dataC,
            "dataUser"=>$dataUser,
        ];
        return response()->json(["status"=>true,"message"=>"Data berhasil difetch!","data"=>$data]);
    }
    public function ceklaporan()
    {
        try {
            $data = Logitem::where('status','=','A')->count();
            // dd($data);
            return response()->json(["status"=>true,"message"=>"Data detail berhasil difetch!","data"=>$data]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function export_laporan() 
    {
        return Excel::download(new LogitemExport, 'laporan.xlsx');

    }

    public function signature(Request $request) 
    {
        $img = $request->file('signature');
        dd($img);
        return response()->json(["status"=>true,"message"=>"Signature berhasil diupload!","data"=>$data]);

    }
}
