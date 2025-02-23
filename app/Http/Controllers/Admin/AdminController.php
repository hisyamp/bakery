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


    public function report()
    {
        $role = Auth::user()->role_id;
        return view('admin.report',compact('role'));
    }

    public function api_report($datestart,$dateend)
    {
        try {
            
            $logItems = Logitem::selectRaw('log_items.item_id, items.name as item_name, SUM(log_items.qty) as total_qty, SUM(log_items.price*qty) as total_price')
            ->join('items', 'log_items.item_id', '=', 'items.id')
            ->whereBetween('log_items.transaction_date', [$datestart, $dateend])
            ->groupBy('log_items.item_id', 'items.name')
            ->get();

            return DataTables::of($logItems)->make(true);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

}
