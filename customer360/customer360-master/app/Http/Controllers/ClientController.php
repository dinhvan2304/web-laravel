<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ClientDataTable;
use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Flash;
use DB;
use App\Http\Controllers\AppBaseController;
use Response;

class ClientController extends AppBaseController
{
    /**
     * Display a listing of the Client.
     *
     * @param ClientDataTable $clientDataTable
     * @return Response
     */
    public function index(ClientDataTable $clientDataTable)
    {
        return $clientDataTable->render('clients.index');
    }

    public function store_client(Request $request){
        $payLoad = json_decode($request->getContent(), true);

        try{
            $result = Client::updateOrCreate(["company_id" => $payLoad["company_id"]], $payLoad);
            $dx = new \App\Services\DatagridService(DB::table('clients'));
            $request->softdelete = True;
            return $dx->invoke($request);
        } catch(QueryException $e){
            return $e->get_message();
        }
    }
    
    public function edit_client(Request $request, $id){
        $payLoad = json_decode($request->getContent(), true);
        try{
            Client::where('id', $id)->update($payLoad);
            $dx = new \App\Services\DatagridService(DB::table('clients'));
            $request->softdelete = True;
            return $dx->invoke($request);
        } catch (QueryException $e){
            return $e->get_message();
        }
        dd($payLoad);
    }

    public function destroy_client(Request $request, $id){
        $id_int = intval($id);
        $client_info = Client::where('id', $id_int)->first();
        try{
            $client_info->delete();
            $dx = new \App\Services\DatagridService(DB::table('clients'));
            $request->softdelete = True;
            $dx_result = $dx->invoke($request);
            return $dx->invoke($request);
        } catch(Exception $e){
            echo json_encode(array("message" => "not ok", "code" => 200));
        }
    }

    /**
     * Show the form for creating a new Client.
     *
     * @return Response
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created Client in storage.
     *
     * @param CreateClientRequest $request
     *
     * @return Response
     */
    public function store(CreateClientRequest $request)
    {
        $input = $request->all();

        /** @var Client $client */
        $client = Client::create($input);

        Flash::success('Client saved successfully.');

        return redirect(route('clients.index'));
    }

    /**
     * Display the specified Client.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Client $client */
        $client = Client::find($id);

        if (empty($client)) {
            Flash::error('Client not found');

            return redirect(route('clients.index'));
        }

        return view('clients.show')->with('client', $client);
    }

    /**
     * Show the form for editing the specified Client.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Client $client */
        $client = Client::find($id);

        if (empty($client)) {
            Flash::error('Client not found');

            return redirect(route('clients.index'));
        }

        return view('clients.edit')->with('client', $client);
    }

    /**
     * Update the specified Client in storage.
     *
     * @param  int              $id
     * @param UpdateClientRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateClientRequest $request)
    {
        /** @var Client $client */
        $client = Client::find($id);

        if (empty($client)) {
            Flash::error('Client not found');

            return redirect(route('clients.index'));
        }

        $client->fill($request->all());
        $client->save();

        Flash::success('Client updated successfully.');

        return redirect(route('clients.index'));
    }

    /**
     * Remove the specified Client from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Client $client */
        $client = Client::find($id);

        if (empty($client)) {
            Flash::error('Client not found');

            return redirect(route('clients.index'));
        }

        $client->delete();

        Flash::success('Client deleted successfully.');

        return redirect(route('clients.index'));
    }
}
