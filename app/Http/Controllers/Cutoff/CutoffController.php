<?php

namespace App\Http\Controllers\Cutoff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Logtype;
use App\Models\Stockitems;
use App\Models\Logitem;
use App\Models\Cutoff;
use DataTables;

class CutoffController extends Controller
{
    public function index()
    {

        $role = Auth::user()->role_id;
        $items = Item::all();
        $log_types = Logtype::all();

        return view('cutoff.cutoff',compact('role','items','log_types'));
    }

    public function list(Request $request)
    {
        $role = Auth::user()->role_id;
        $items = Item::all();
        $log_types = Logtype::all();

        return view('cutoff.cutoff_list',compact('role','items','log_types'));
    }

    public function detail_list($id)
    {
        $role = Auth::user()->role_id;
        $items = Item::all();
        $log_types = Logtype::all();
        $data = LogItem::where('cutoff_id','=',$id)->get();
        // $link_req_datatable = route('api_cutoff'/$id);
        // dd($link_req_datatable);
        
        return view('cutoff.detail_cutoff_list',compact('role','items','log_types','data','id'));
    }

    public function api_cutoff_list()
    {
        // Fetch log_items grouped by item_id
        $results = DB::table('log_items')
            ->join('items', 'items.id', '=', 'log_items.item_id') // Join with items table
            ->select([
                'log_items.cutoff_id',
                'log_items.item_id',
                'items.name AS item_name',
                DB::raw('SUM(CASE WHEN type_log_id = 1 THEN qty ELSE 0 END) AS finishgood'),
                DB::raw('SUM(CASE WHEN type_log_id = 2 THEN qty ELSE 0 END) AS waste'),
                DB::raw('SUM(CASE WHEN type_log_id = 3 THEN qty ELSE 0 END) AS sell'),
            ])
            ->whereNull('log_items.cutoff_id')
            ->whereIn('type_log_id', [1, 2, 3])
            ->groupBy('log_items.item_id', 'items.name', 'log_items.cutoff_id')
            ->orderBy('log_items.item_id')
            ->get();
    
        // Get the last transaction date from Stockitems
        $lastDate = Stockitems::max('transaction_date');
    
        // Fetch Stockitems data for the last transaction date
        $stockData = Stockitems::whereDate('transaction_date', '=', $lastDate)
            ->get()
            ->keyBy('item_id'); // Convert to an associative array for easier access
    
        // Merge StockItem data with log_items results
        $results->transform(function ($item) use ($stockData) {
            // Get stok_akhir from stockData, default to 0 if not found
            $stok_akhir = $stockData[$item->item_id]->stok_akhir ?? 0;
            $finishgood = $item->finishgood ?? 0;
            $waste = $item->waste ?? 0;
            $sell = $item->sell ?? 0;
    
            // Keep stok_akhir in the response
            $item->stok_akhir = $stok_akhir;
    
            // Calculate net_stock including stok_akhir
            $item->net_stock = $stok_akhir + $finishgood - $waste - $sell;
    
            return $item;
        });
    
        return DataTables::of($results)->make(true);
    }
    
    
    public function api_cutoff(Request $request)
    {
        $data = Cutoff::orderBy('id', 'desc')->get();
        return DataTables::of($data)->make(true);
    }

    public function api_detail_cutoff(Request $request)
    {
        $result = DB::table('log_items')
        ->select(
            'item_id',
            DB::raw("SUM(CASE WHEN type_log_id = '1' THEN qty ELSE 0 END) AS finishgood_qty"),
            DB::raw("SUM(CASE WHEN type_log_id = '2' THEN qty ELSE 0 END) AS waste_qty"),
            DB::raw("SUM(CASE WHEN type_log_id = '3' THEN qty ELSE 0 END) AS sell_qty")
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('item_id')
        ->get();
        return $result;
    }

    public function do_cutoff(Request $request)
    {
        $data = $request->all();
        // dd($data);
        // Validate the request
        $request->validate([
            'cutoff_name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
    
        // Start a database transaction
        // DB::beginTransaction();
        try {
            // Search for transactions in `log_items` within the date range
            $logItems = LogItem::
            whereBetween('transaction_date', ['2024-01-04', '2025-01-11'])
            ->whereNull('cutoff_id')->get();
    
            // Group by item_id and calculate finishgood, waste, sell, and net_stock
            $itemQuantities = $logItems->groupBy('item_id')->map(function ($items) {
                return [
                    'finishgood' => $items->where('type_log_id', 1)->sum('qty'),
                    'waste' => $items->where('type_log_id', 2)->sum('qty'),
                    'sell' => $items->where('type_log_id', 3)->sum('qty'),
                    'net_stock' => $items->where('type_log_id', 1)->sum('qty') 
                                 - $items->where('type_log_id', 2)->sum('qty') 
                                 - $items->where('type_log_id', 3)->sum('qty'),
                ];
            });
            // dd($itemQuantities);
            // Update stock_items for each item
            foreach ($itemQuantities as $itemId => $quantities) {
                $latestStock = Stockitems::where('item_id', $itemId)
                    ->orderBy('transaction_date', 'desc')
                    ->first();
    
                $newStock = new Stockitems([
                    'item_id' => $itemId,
                    'stok_awal' => $latestStock ? $latestStock->stock_akhir : 0,
                    'stok_akhir' => $latestStock ? $latestStock->stock_akhir + $quantities['net_stock'] : $quantities['net_stock'],
                    'transaction_date' => now(),
                    'created_by' => auth()->id(),
                ]);
                // dd($newStock);
                $newStock->save();
            }
    
            // Create cutoff record
            $cutoff = Cutoff::create([
                'cutoff_name' => $request->cutoff_name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => 'closed',
                'created_by' => auth()->id(),
                'closed_at' => now(),
                'notes' => $request->notes,
            ]);
    
            // Update the queried LogItem records with the cutoff_id
            LogItem::whereBetween('transaction_date', ['2024-01-04', '2025-01-11'])
                ->update(['cutoff_id' => $cutoff->id]);
    
            // Commit the transaction
            // DB::commit();
            return response()->json([
                'message' => 'Cutoff process completed successfully.',
                'cutoff' => $cutoff,
                'item_quantities' => $itemQuantities, // Include item quantities in the response
            ], 201);
    
        } catch (\Exception $e) {
            // Rollback transaction if there's an error
            dd($e->getMessage());
            // DB::rollBack();
            return response()->json([
                'message' => 'Failed to complete cutoff process.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    
    
}
