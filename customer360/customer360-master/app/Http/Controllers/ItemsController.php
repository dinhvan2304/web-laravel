<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;
use DB;
use Illuminate\Database\QueryException;

class ItemsController extends Controller
{
    
    public function category_item(Request $request){
        $dx = new \App\Services\DatagridService(DB::table('category_items'));
        $request->softdelete = True;
        return $dx->invoke($request);
    }

    public function store_items(Request $request){
        $payLoad = json_decode($request->getContent(), true);

        try{
            $result = Items::updateOrCreate(["name" => $payLoad["name"]], $payLoad);
            $dx = new \App\Services\DatagridService(DB::table('category_items'));
            $request->softdelete = True;
            return $dx->invoke($request);
        } catch(QueryException $e){
            return $e->get_message();
        }
    }
    
    public function edit_items(Request $request, $id){
        $payLoad = json_decode($request->getContent(), true);
        try{
            Items::where('id', $id)->update($payLoad);
            $dx = new \App\Services\DatagridService(DB::table('category_items'));
            $request->softdelete = True;
            return $dx->invoke($request);
        } catch (QueryException $e){
            return $e->get_message();
        }
        dd($payLoad);
    }

    public function destroy_items(Request $request, $id){
        $id_int = intval($id);
        $items_info = Items::where('id', $id_int)->first();
        try{
            $items_info->delete();
            $dx = new \App\Services\DatagridService(DB::table('category_items'));
            $request->softdelete = True;
            $dx_result = $dx->invoke($request);
            return $dx->invoke($request);
        } catch(Exception $e){
            echo json_encode(array("message" => "not ok", "code" => 200));
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function show(Items $items)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function edit(Items $items)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Items $items)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function destroy(Items $items)
    {
        //
    }
}
