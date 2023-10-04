<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use App\DataTables\BusinessDataTable;
use Flash;
use Illuminate\Database\QueryException;
use DB;

class BusinessController extends Controller
{

    public function businesses(Request $request){
        $dx = new \App\Services\DatagridService(DB::table('business'));
        $request->softdelete = True;
        return $dx->invoke($request);
    }

    public function store_businesses(Request $request){
        $payLoad = json_decode($request->getContent(), true);

        try{
            $result = Business::updateOrCreate(["name" => $payLoad["name"]], $payLoad);
            $dx = new \App\Services\DatagridService(DB::table('business'));
            $request->softdelete = True;
            return $dx->invoke($request);
        } catch(QueryException $e){
            return $e->get_message();
        }
    }
    
    public function edit_businesses(Request $request, $id){
        $payLoad = json_decode($request->getContent(), true);
        try{
            Business::where('id', $id)->update($payLoad);
            $dx = new \App\Services\DatagridService(DB::table('business'));
            $request->softdelete = True;
            return $dx->invoke($request);
        } catch (QueryException $e){
            return $e->get_message();
        }
        dd($payLoad);
    }

    public function destroy_businesses(Request $request, $id){
        $id_int = intval($id);
        $business_info = Business::where('id', $id_int)->first();
        try{
            $business_info->delete();
            $dx = new \App\Services\DatagridService(DB::table('business'));
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
    public function index(BusinessDataTable $businessDataTable)
    {
        return $businessDataTable->render('business.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $is_parent = 0;
        $business_list = Business::all()->pluck('name', 'id');
        $is_show = "block";

        return view('business.create')->with('business_list', $business_list)->with('is_parent', $is_parent)->with('is_show', $is_show);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except(['_token']);
        if ($input["is_parent"] == 1){
            $input["parent_id"] = null;
        } 
        try{
            $result = Business::updateOrCreate(["name" => $input["name"]], $input);
            Flash::success('Business saved successfully');
        } catch(QueryException $e){
            Flash::error("Business saved failed" . $e->get_message());
        }
        
        return redirect(route('business.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business)
    {
        $business_list = Business::all()->pluck('name', 'id');
        $parent_id = 0;
        $is_show = "block";
        if ($business["parent_id"] == null){
            $parent_id = 1;
            $is_show = "none";
        }
        return view('business.edit')->with('business', $business)->with('business_list', $business_list)->with('is_parent', $parent_id)->with('is_show', $is_show);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Business $business)
    {
        if (empty($business)){
            Flash::error("Business not found");
            return redirect(route('business.index'));
        }

        $input = $request->except(['_token']);
        $business->fill($input);
        $business->save(); 
        Flash::success('Business updated successfully');
        return redirect(route('business.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business)
    {
        if (empty($business)){
            Flash::error("Business not found");
            return redirect(route('business.index')); 
        }
        $business->delete();
        Flash::success('Business deleted successfully');
        return redirect(route('business.index'));
    }
}
