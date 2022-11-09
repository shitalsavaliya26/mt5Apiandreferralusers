<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRankAPIRequest;
use App\Http\Requests\API\UpdateRankAPIRequest;
use App\Models\Rank;
use App\Repositories\RankRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class RankController
 * @package App\Http\Controllers\API
 */

class RankAPIController extends AppBaseController
{
    /** @var  RankRepository */
    private $rankRepository;

    public function __construct(RankRepository $rankRepo)
    {
        $this->rankRepository = $rankRepo;
    }

    /**
     * Display a listing of the Rank.
     * GET|HEAD /ranks
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $ranks = $this->rankRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($ranks->toArray(), 'Ranks retrieved successfully');
    }

    /**
     * Store a newly created Rank in storage.
     * POST /ranks
     *
     * @param CreateRankAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateRankAPIRequest $request)
    {
        $input = $request->all();

        $rank = $this->rankRepository->create($input);

        return $this->sendResponse($rank->toArray(), 'Rank saved successfully');
    }

    /**
     * Display the specified Rank.
     * GET|HEAD /ranks/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Rank $rank */
        $rank = $this->rankRepository->find($id);

        if (empty($rank)) {
            return $this->sendError('Rank not found');
        }

        return $this->sendResponse($rank->toArray(), 'Rank retrieved successfully');
    }

    /**
     * Update the specified Rank in storage.
     * PUT/PATCH /ranks/{id}
     *
     * @param int $id
     * @param UpdateRankAPIRequest $request
     *
     * @return Response
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

        return $this->sendResponse($rank->toArray(), 'Rank updated successfully');
    }

    /**
     * Remove the specified Rank from storage.
     * DELETE /ranks/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Rank $rank */
        $rank = $this->rankRepository->find($id);

        if (empty($rank)) {
            return $this->sendError('Rank not found');
        }

        $rank->delete();

        return $this->sendSuccess('Rank deleted successfully');
    }
}
