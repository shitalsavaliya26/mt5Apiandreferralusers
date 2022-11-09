<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateRankAPIRequest;
use App\Http\Requests\API\UpdateRankAPIRequest;
use App\Models\Package;
use App\Models\Rank;
use App\Repositories\RankRepository;
use Illuminate\Http\Request;
use Response;

/**
 * Class RankController
 * @package App\Http\Controllers\API
 */
class RankController extends AppBaseController
{
    /** @var  RankRepository */
    private $rankRepository;

    public function __construct(RankRepository $rankRepo)
    {
        $this->middleware('auth:admin');
        $this->rankRepository = $rankRepo;
    }

    /**
     * Display a listing of the Rank.
     * GET|HEAD /ranks
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $ranks = Rank::paginate(8);

        return view('admin.admin_ranks', compact('ranks'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $packages = Package::all();

        return view('admin.admin_create_rank', compact('packages'));
    }

    /**
     * Display the specified Rank.
     * GET|HEAD /ranks/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        /** @var Rank $rank */
        $rank = $this->rankRepository->find($id);

        if (empty($rank)) {
            return $this->sendError('Rank not found');
        }

        return view('admin.show_rank', compact('rank'));
    }

    /**
     * Store a newly created Rank in storage.
     * POST /ranks
     *
     * @param CreateRankAPIRequest $request
     *
     * @return
     */
    public function store(CreateRankAPIRequest $request)
    {
        $input = $request->all();

        $rank = $this->rankRepository->create($input);

        return redirect('avanya-vip-portal/ranks')->with('message', 'Rank created successfully.');

    }

    /** Check rank exist or not
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkRank(Request $request)
    {
        if ($request->rankId) {
            $rank = Rank::where('name',$request->name)->where('id','!=',$request->rankId)->where('deleted_at',null)->get();
        } else {
            $rank = Rank::where('name',$request->name)->where('deleted_at',null)->get();
        }

        if (count($rank) > 0) {
            return Response::json(array('msg' => 'true'));
        } else {
            return Response::json(array('msg' => 'false'));
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        /** @var Rank $rank */
        $rank = $this->rankRepository->find($id);

        if (empty($rank)) {
            return $this->sendError('Rank not found');
        }

        $packages = Package::all();

        return view('admin.admin_edit_rank', compact('rank', 'packages'));
    }

    /**
     * Update the specified Rank in storage.
     * PUT/PATCH /ranks/{id}
     *
     * @param int $id
     * @param UpdateRankAPIRequest $request
     *
     * @return
     */
    public function update($id, UpdateRankAPIRequest $request)
    {
        $input = $request->all();

        /** @var Rank $rank */
        $rank = $this->rankRepository->find($id);

        if (empty($rank)) {
            return $this->sendError('Rank not found');
        }

        $rank = $this->rankRepository->update($input, $id);

        return redirect('avanya-vip-portal/ranks')->with('message', 'Rank updated successfully.');
    }

    /**
     * Remove the specified Rank from storage.
     * DELETE /ranks/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        /** @var Rank $rank */
        $rank = $this->rankRepository->find($id);

        if (empty($rank)) {
            return $this->sendError('Rank not found');
        }

        $rank->delete();

        return back()->with('message', 'Rank deleted successfully.');
    }
}
