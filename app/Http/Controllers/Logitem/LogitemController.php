<?php

namespace App\Http\Controllers\Logitem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logitem;
use App\Models\Item;
use App\Models\Logtype;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use DataTables;

class LogitemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Auth::user()->role_id;
        $items = Item::all();
        $log_types = Logtype::all();

        return view('logitem.logitem',compact('role','items','log_types'));
    }

    public function add_log_item()
    {
        $role = Auth::user()->role_id;
        $items = Item::all();
        $log_types = Logtype::all();
        $latestLogItem = LogItem::orderBy('transaction_date', 'desc')->first();
        $latestLogItemDate = $latestLogItem ? $latestLogItem->transaction_date : null;
        // dd($latestLogItem);
        return view('logitem.create-logitem',compact('role','items','log_types','latestLogItemDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
     public function store(Request $request)
     {
         try {
             // Validate the incoming request data (optional but recommended)
             // $validatedData = $request->validate([
             //     'item_id' => 'required|integer',
             //     'transaction_date' => 'required|date',
             //     // Add more validation rules as needed
             // ]);
             $requestData = $request->all();
             
             $item = Item::find($request->item_id);
             $snapshot_price = $item->price;
             $requestData['price'] = $snapshot_price??0;
            
             // Check if an item with the same 'item_id' and 'transaction_date' already exists
             $logitem = Logitem::where('item_id', $request->item_id)
                 ->where('type_log_id', $request->type_log_id)
                 ->whereDate('transaction_date', $request->transaction_date)
                 ->first();
     
             if ($logitem) {
                 // If a record exists, update it with the new data
                 $logitem->update($requestData);
             } else {
                 // If no record exists, create a new one
                 $logitem = Logitem::create($requestData);
             }
     
             // Return a success response
             return response()->json([
                 'message' => 'Log item created or updated successfully',
                 'data' => $logitem
             ], 201);
     
         } catch (\Throwable $th) {
             // Handle error (you can log the error or return a custom error message)
             return response()->json([
                 'message' => 'Error processing the request',
                 'error' => $th->getMessage()
             ], 500);
         }
     }
     

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $logitem = Logitem::find($id);
        return $logitem;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the log item by ID and check if it exists
        $logItem = LogItem::find($id);
    
        if ($logItem) {
            // Mark the record as deleted
            $logItem->deleted_at = now();  // Use Laravel's `now()` helper for the current timestamp
            $logItem->save();    

            return response()->json(['message' => 'Log item safely deleted']);
        }
    
        return response()->json(['message' => 'Log item not found'], 404);
    }

    public function api_log(Request $request)
    {        
        $query = DB::table('log_items')
            ->join('items', 'log_items.item_id', '=', 'items.id')
            ->join('log_types', 'log_items.type_log_id', '=', 'log_types.id')
            ->select('log_items.*', 'items.name as name', 'log_types.name as log_type_name')
            ->whereNull('log_items.cutoff_id')
            ->whereNull('log_items.deleted_at');

        if($request->has('id')){
            $query->where('cutoff_id','=',$request->id);
        }
        // Optional parameter: type_log_id
        if ($request->has('type_log_id')) {
            $query->where('log_items.type_log_id', $request->type_log_id);
        }

        // Optional parameter: date
        if ($request->has('date')) {
            $query->whereDate('log_items.transaction_date', $request->date);
        }

        $data = $query->get();

        return DataTables::of($data)->make(true);
    }


}
