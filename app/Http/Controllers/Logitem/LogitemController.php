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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    public function api_log()
    {
        $data = DB::table('log_items')
        ->join('items', 'log_items.item_id', '=', 'items.id')
        ->join('log_types', 'log_items.type_log_id', '=', 'log_types.id')
        ->select('log_items.*', 'items.name as name', 'log_types.name as log_type_name')
        ->get();
    
        return DataTables::of($data)->make(true);
    }
}
