<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreatePackageAPIRequest;
use App\Http\Requests\API\UpdatePackageAPIRequest;
use App\Models\Package;
use App\Repositories\PackageRepository;
use Illuminate\Http\Request;
use Response;

/**
 * Class PackageController
 * @package App\Http\Controllers\API
 */
class PackageController extends AppBaseController
{
    /** @var  PackageRepository */
    private $packageRepository;

    public function __construct(PackageRepository $packageRepo)
    {
        $this->middleware('auth:admin');
        $this->packageRepository = $packageRepo;
    }

    /**
     * Display a listing of the Package.
     * GET|HEAD /packages
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $packages = $this->packageRepository->all();

        return view('admin.admin_packages', compact('packages'));
    }

    public function create()
    {

        return view('admin.admin_create_package');
    }

    /**
     * Store a newly created Package in storage.
     * POST /packages
     *
     * @param CreatePackageAPIRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreatePackageAPIRequest $request)
    {
        $input = $request->all();

        $package = $this->packageRepository->create($input);

        return redirect('avanya-vip-portal/packages')->with('message', 'package succesfully created');
    }


    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {

        /** @var Package $package */
        $package = $this->packageRepository->find($id);

        if (empty($package)) {
            return $this->sendError('Package not found');
        }

        return view('admin.admin_edit_package', compact('package'));
    }

    /**
     * Update the specified Package in storage.
     * PUT/PATCH /packages/{id}
     *
     * @param int $id
     * @param UpdatePackageAPIRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, UpdatePackageAPIRequest $request)
    {
        $input = $request->all();

        /** @var Package $package */
        $package = $this->packageRepository->find($id);

        if (empty($package)) {
            return $this->sendError('Package not found');
        }

        $package = $this->packageRepository->update($input, $id);

        return redirect('avanya-vip-portal/packages')->with('message', 'package successfully updated');

    }

    /**
     * Remove the specified Package from storage.
     * DELETE /packages/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        /** @var Package $package */
        $package = $this->packageRepository->find($id);

        if (empty($package)) {
            return $this->sendError('Package not found');
        }

        $package->delete();

        return back()->with('message', 'package successfully deleted');
    }
}
