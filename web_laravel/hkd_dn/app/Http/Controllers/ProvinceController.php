<?php

namespace App\Http\Controllers;

use App\DataTables\ProvinceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateProvinceRequest;
use App\Http\Requests\UpdateProvinceRequest;
use App\Models\Province;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ProvinceController extends AppBaseController
{

    public function provinces(Request $request){
        $dx = new \App\Services\DatagridService(DB::table('provinces'));
        $request->softdelete = True;
        return $dx->invoke($request);
    }

    public function store_provinces(Request $request){
        $payLoad = json_decode($request->getContent(), true);

        try{
            $result = Province::updateOrCreate(["name" => $payLoad["name"]], $payLoad);
            $dx = new \App\Services\DatagridService(DB::table('business'));
            $request->softdelete = True;
            return $dx->invoke($request);
        } catch(QueryException $e){
            return $e->get_message();
        }
    }
    
    public function edit_provinces(Request $request, $id){
        $payLoad = json_decode($request->getContent(), true);
        try{
            Province::where('id', $id)->update($payLoad);
            $dx = new \App\Services\DatagridService(DB::table('provinces'));
            $request->softdelete = True;
            return $dx->invoke($request);
        } catch (QueryException $e){
            return $e->get_message();
        }
        dd($payLoad);
    }

    public function destroy_provinces(Request $request, $id){
        $id_int = intval($id);
        $business_info = Province::where('id', $id_int)->first();
        try{
            $business_info->delete();
            $dx = new \App\Services\DatagridService(DB::table('provinces'));
            $request->softdelete = True;
            $dx_result = $dx->invoke($request);
            return $dx->invoke($request);
        } catch(Exception $e){
            echo json_encode(array("message" => "not ok", "code" => 200));
        }
    }


    /**
     * Display a listing of the Province.
     *
     * @param ProvinceDataTable $provinceDataTable
     * @return Response
     */
    public function index(ProvinceDataTable $provinceDataTable)
    {
        return $provinceDataTable->render('provinces.index');
    }

    /**
     * Show the form for creating a new Province.
     *
     * @return Response
     */
    public function create()
    {
        return view('provinces.create');
    }

    /**
     * Store a newly created Province in storage.
     *
     * @param CreateProvinceRequest $request
     *
     * @return Response
     */
    public function store(CreateProvinceRequest $request)
    {
        $input = $request->all();

        /** @var Province $province */
        $province = Province::create($input);

        Flash::success('Province saved successfully.');

        return redirect(route('provinces.index'));
    }

    /**
     * Display the specified Province.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Province $province */
        $province = Province::find($id);

        if (empty($province)) {
            Flash::error('Province not found');

            return redirect(route('provinces.index'));
        }

        return view('provinces.show')->with('province', $province);
    }

    /**
     * Show the form for editing the specified Province.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Province $province */
        $province = Province::find($id);

        if (empty($province)) {
            Flash::error('Province not found');

            return redirect(route('provinces.index'));
        }

        return view('provinces.edit')->with('province', $province);
    }

    /**
     * Update the specified Province in storage.
     *
     * @param  int              $id
     * @param UpdateProvinceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProvinceRequest $request)
    {
        /** @var Province $province */
        $province = Province::find($id);

        if (empty($province)) {
            Flash::error('Province not found');

            return redirect(route('provinces.index'));
        }

        $province->fill($request->all());
        $province->save();

        Flash::success('Province updated successfully.');

        return redirect(route('provinces.index'));
    }

    /**
     * Remove the specified Province from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Province $province */
        $province = Province::find($id);

        if (empty($province)) {
            Flash::error('Province not found');

            return redirect(route('provinces.index'));
        }

        $province->delete();

        Flash::success('Province deleted successfully.');

        return redirect(route('provinces.index'));
    }
}
