<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserDemoAPIRequest;
use App\Http\Requests\API\UpdateUserDemoAPIRequest;
use App\Models\UserDemo;
use App\Repositories\UserDemoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UserDemoController
 * @package App\Http\Controllers\API
 */

class UserDemoAPIController extends AppBaseController
{
    /** @var  UserDemoRepository */
    private $userDemoRepository;

    public function __construct(UserDemoRepository $userDemoRepo)
    {
        $this->userDemoRepository = $userDemoRepo;
    }

    /**
     * Display a listing of the UserDemo.
     * GET|HEAD /userDemos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userDemos = $this->userDemoRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($userDemos->toArray(), 'User Demos retrieved successfully');
    }

    /**
     * Store a newly created UserDemo in storage.
     * POST /userDemos
     *
     * @param CreateUserDemoAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserDemoAPIRequest $request)
    {
        $input = $request->all();

        $userDemo = $this->userDemoRepository->create($input);

        return $this->sendResponse($userDemo->toArray(), 'User Demo saved successfully');
    }

    /**
     * Display the specified UserDemo.
     * GET|HEAD /userDemos/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserDemo $userDemo */
        $userDemo = $this->userDemoRepository->find($id);

        if (empty($userDemo)) {
            return $this->sendError('User Demo not found');
        }

        return $this->sendResponse($userDemo->toArray(), 'User Demo retrieved successfully');
    }

    /**
     * Update the specified UserDemo in storage.
     * PUT/PATCH /userDemos/{id}
     *
     * @param int $id
     * @param UpdateUserDemoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserDemoAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserDemo $userDemo */
        $userDemo = $this->userDemoRepository->find($id);

        if (empty($userDemo)) {
            return $this->sendError('User Demo not found');
        }

        $userDemo = $this->userDemoRepository->update($input, $id);

        return $this->sendResponse($userDemo->toArray(), 'UserDemo updated successfully');
    }

    /**
     * Remove the specified UserDemo from storage.
     * DELETE /userDemos/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserDemo $userDemo */
        $userDemo = $this->userDemoRepository->find($id);

        if (empty($userDemo)) {
            return $this->sendError('User Demo not found');
        }

        $userDemo->delete();



        return $this->sendSuccess('User Demo deleted successfully');
    }
}
