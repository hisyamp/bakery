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
        try {
            $data = Logitem::whereNull('cutoff_id');
            return DataTables::of($data)->make(true);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
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

    public function api_report(Request $request)
    {
        try {
            $datestart = $request->input('datestart');
            $dateend = $request->input('dateend');
    
            $logItems = Logitem::selectRaw('
                    log_items.item_id, 
                    items.name as item_name, 
                    SUM(CASE WHEN log_items.type_log_id = 2 THEN log_items.qty ELSE 0 END) as qty_waste,
                    SUM(CASE WHEN log_items.type_log_id = 1 THEN log_items.qty ELSE 0 END) as qty_finish_good,
                    SUM(log_items.price * log_items.qty) as total_price,
                    CASE 
                        WHEN SUM(CASE WHEN log_items.type_log_id = 1 THEN log_items.qty ELSE 0 END) = 0 
                        THEN NULL 
                        ELSE 
                            ROUND(
                                (SUM(CASE WHEN log_items.type_log_id = 2 THEN log_items.qty ELSE 0 END) / 
                                SUM(CASE WHEN log_items.type_log_id = 1 THEN log_items.qty ELSE 0 END)) * 100, 2
                            )
                    END as total_percentage
                ')
                ->join('items', 'log_items.item_id', '=', 'items.id')
                ->whereBetween('log_items.transaction_date', [$datestart, $dateend])
                ->groupBy('log_items.item_id', 'items.name')
                ->get();
            return [$datestart, $dateend];
            return DataTables::of($logItems)->make(true);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    
    
    
}
