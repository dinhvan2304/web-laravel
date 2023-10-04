<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\PackageDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Models\Package;
use Flash;
use DB;
use App\Http\Controllers\AppBaseController;
use Response;

class PackageController extends AppBaseController
{
    /**
     * Display a listing of the Package.
     *
     * @param PackageDataTable $packageDataTable
     * @return Response
     */
    public function index(PackageDataTable $packageDataTable)
    {
        return $packageDataTable->render('packages.index');
    }

    /**
     * Show the form for creating a new Package.
     *
     * @return Response
     */
    public function create()
    {
        return view('packages.create');
    }

    /**
     * Store a newly created Package in storage.
     *
     * @param CreatePackageRequest $request
     *
     * @return Response
     */
    public function store(CreatePackageRequest $request)
    {
        $input = $request->all();

        /** @var Package $package */
        $package = Package::create($input);

        Flash::success('Package saved successfully.');

        return redirect(route('packages.index'));
    }

    /**
     * Display the specified Package.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Package $package */
        $package = Package::find($id);

        if (empty($package)) {
            Flash::error('Package not found');

            return redirect(route('packages.index'));
        }

        return view('packages.show')->with('package', $package);
    }

    /**
     * Show the form for editing the specified Package.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Package $package */
        $package = Package::find($id);

        if (empty($package)) {
            Flash::error('Package not found');

            return redirect(route('packages.index'));
        }

        return view('packages.edit')->with('package', $package);
    }

    /**
     * Update the specified Package in storage.
     *
     * @param  int              $id
     * @param UpdatePackageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePackageRequest $request)
    {
        /** @var Package $package */
        $package = Package::find($id);

        if (empty($package)) {
            Flash::error('Package not found');

            return redirect(route('packages.index'));
        }

        $package->fill($request->all());
        $package->save();

        Flash::success('Package updated successfully.');

        return redirect(route('packages.index'));
    }

    /**
     * Remove the specified Package from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Package $package */
        $package = Package::find($id);

        if (empty($package)) {
            Flash::error('Package not found');

            return redirect(route('packages.index'));
        }

        $package->delete();

        Flash::success('Package deleted successfully.');

        return redirect(route('packages.index'));
    }
}
