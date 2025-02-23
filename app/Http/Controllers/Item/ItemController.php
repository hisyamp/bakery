<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use DataTables;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Auth::user()->role_id;
        $categories = Category::all();
        $branch = Branch::all();

        return view('item.item',compact('role','categories','branch'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|exists:categories,id',
            'branch_id' => 'required|exists:branchs,id',
            'price' => 'required|numeric|min:0',
        ]);

        $item = Item::create($validated);

        return response()->json(["status"=>'success',"message"=> 'Item created successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Item::find($id);
        return $data;
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
        $item = Item::findOrFail($id);
        $item->deleted_at = now();
        $item->save();
        return response()->json(['message' => 'Item deleted successfully.']);

    }

    public function api_item()
    {
        $data = Item::select('items.id','items.name', 'items.price', 'categories.name as category')
            ->whereNull('items.deleted_at')
            ->leftJoin('categories', 'items.category', '=', 'categories.id')
            ->get();

        return DataTables::of($data)->make(true);
    }

}
