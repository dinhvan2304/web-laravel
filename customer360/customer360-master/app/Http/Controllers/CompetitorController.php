<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\CompetitorDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCompetitorRequest;
use App\Http\Requests\UpdateCompetitorRequest;
use App\Models\Competitor;
use Flash;
use DB;
use App\Http\Controllers\AppBaseController;
use Response;

class CompetitorController extends AppBaseController
{
    /**
     * Display a listing of the Competitor.
     *
     * @param CompetitorDataTable $competitorDataTable
     * @return Response
     */
    public function index(CompetitorDataTable $competitorDataTable)
    {
        return $competitorDataTable->render('competitors.index');
    }

    /**
     * Show the form for creating a new Competitor.
     *
     * @return Response
     */
    public function create()
    {
        return view('competitors.create');
    }

    /**
     * Store a newly created Competitor in storage.
     *
     * @param CreateCompetitorRequest $request
     *
     * @return Response
     */
    public function store(CreateCompetitorRequest $request)
    {
        $input = $request->all();

        /** @var Competitor $competitor */
        $competitor = Competitor::create($input);

        Flash::success('Competitor saved successfully.');

        return redirect(route('competitors.index'));
    }

    /**
     * Display the specified Competitor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Competitor $competitor */
        $competitor = Competitor::find($id);

        if (empty($competitor)) {
            Flash::error('Competitor not found');

            return redirect(route('competitors.index'));
        }

        return view('competitors.show')->with('competitor', $competitor);
    }

    /**
     * Show the form for editing the specified Competitor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Competitor $competitor */
        $competitor = Competitor::find($id);

        if (empty($competitor)) {
            Flash::error('Competitor not found');

            return redirect(route('competitors.index'));
        }

        return view('competitors.edit')->with('competitor', $competitor);
    }

    /**
     * Update the specified Competitor in storage.
     *
     * @param  int              $id
     * @param UpdateCompetitorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompetitorRequest $request)
    {
        /** @var Competitor $competitor */
        $competitor = Competitor::find($id);

        if (empty($competitor)) {
            Flash::error('Competitor not found');

            return redirect(route('competitors.index'));
        }

        $competitor->fill($request->all());
        $competitor->save();

        Flash::success('Competitor updated successfully.');

        return redirect(route('competitors.index'));
    }

    /**
     * Remove the specified Competitor from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Competitor $competitor */
        $competitor = Competitor::find($id);

        if (empty($competitor)) {
            Flash::error('Competitor not found');

            return redirect(route('competitors.index'));
        }

        $competitor->delete();

        Flash::success('Competitor deleted successfully.');

        return redirect(route('competitors.index'));
    }
}
