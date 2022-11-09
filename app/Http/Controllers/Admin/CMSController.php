<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateCMSAPIRequest;
use App\Http\Requests\API\UpdateCMSAPIRequest;
use App\Models\CMS;
use App\Repositories\CMSRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Response;

/**
 * Class CMSController
 * @package App\Http\Controllers
 */
class CMSController extends AppBaseController
{
    /** @var  CMSRepository */
    private $cmsRepository;

    public function __construct(CMSRepository $cmsRepo)
    {
        $this->middleware('auth:admin');
        $this->cmsRepository = $cmsRepo;
    }

    /**
     * Display a listing of the CMS.
     * GET|HEAD /cms
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $cms = CMS::paginate(4);

        return view('admin.admin_cms', compact('cms'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.admin_create_cms');
    }


    /**
     * Store a newly created CMS in storage.
     * POST /cms
     *
     * @param CreateCMSAPIRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateCMSAPIRequest $request)
    {
        $input = $request->all();

        $image = $request->file('image');

        $input['image'] = $image->getClientOriginalName();

        $cms = $this->cmsRepository->create($input);

        $image->storeAs('cms_images', $image->getClientOriginalName());

        return redirect('avanya-vip-portal/cms')->with('message', 'cms created successfully.');
    }

    /**
     * Display the specified CMS.
     * GET|HEAD /cms/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        /** @var CMS $cms */
        $cms = $this->cmsRepository->find($id);

        if (empty($cms)) {
            return $this->sendError('CMS not found');
        }

        return view('admin.show_cms', compact('cms'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        /** @var CMS $cms */
        $cms = $this->cmsRepository->find($id);

        if (empty($cms)) {
            return $this->sendError('CMS not found');
        }

        return view('admin.admin_edit_cms', compact('cms'));
    }

    /**
     * Update the specified CMS in storage.
     * PUT/PATCH /cms/{id}
     *
     * @param int $id
     * @param UpdateCMSAPIRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, UpdateCMSAPIRequest $request)
    {
        $input = $request->all();

        /** @var CMS $cms */
        $cms = $this->cmsRepository->find($id);

        if (empty($cms)) {
            return $this->sendError('CMS not found');
        }

        if ($request->hasFile('image')) {

            $usersImage = public_path("cms_images/{$cms->image}"); // get previous image from folder
            if (File::exists($usersImage)) { // unlink or remove previous image from folder
                unlink($usersImage);
            }

            $image = $request->file('image');

            $input['image'] = $image->getClientOriginalName();

            $cms = $this->cmsRepository->update($input, $id);

            $image->storeAs('cms_images', $image->getClientOriginalName());

        }

        $this->cmsRepository->update($input, $id);

        return redirect('avanya-vip-portal/cms')->with('message', 'cms updated successfully.');
    }

    /**
     * Remove the specified CMS from storage.
     * DELETE /cms/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        /** @var CMS $cms */
        $cms = $this->cmsRepository->find($id);

        if (empty($cms)) {
            return $this->sendError('CMS not found');
        }

        $cms->delete();

        return back()->with('message', 'CMS deleted successfully.');
    }
}
