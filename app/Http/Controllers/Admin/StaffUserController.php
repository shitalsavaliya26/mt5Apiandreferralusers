<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateRoleAPIRequest;
use App\Http\Requests\API\CreateStaffUserAPIRequest;
use App\Http\Requests\API\UpdateRoleAPIRequest;
use App\Http\Requests\API\UpdateStaffUserAPIRequest;
use App\Models\StaffUser;
use App\Repositories\StaffUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

/**
 * Class StaffUserController
 * @package App\Http\Controllers
 */
class StaffUserController extends AppBaseController
{
    /** @var  StaffUserRepository */
    private $staffUserRepository;

    public function __construct(StaffUserRepository $staffRepo)
    {
        $this->middleware('auth:admin');
        $this->staffUserRepository = $staffRepo;
    }

    /**
     * Display a listing of the Role.
     * GET|HEAD /staffUsers
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $staffUsers = Admin::paginate(8);

        return view('admin.staff-users.users', compact('staffUsers'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('admin.staff-users.create_user', compact('roles'));
    }

    /**
     * Store a newly created Role in storage.
     * POST /staffUsers
     *
     * @param CreateRoleAPIRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateStaffUserAPIRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        /** @var StaffUser $staffUser */
        $staffUser = $this->staffUserRepository->create($input);

        $staffUser->assignRole($input['roles']);

        return redirect('avanya-vip-portal/staff-users')->with('message', 'Staff user created successfully.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        /** @var StaffUser $staffUser */
        $staffUser = $this->staffUserRepository->find($id);

        $roles = Role::pluck('name', 'name')->all();
        $userRole = $staffUser->roles->pluck('name', 'name')->all();

        return view('admin.staff-users.edit_user', compact('staffUser', 'roles', 'userRole'));
    }


    /**
     * Update the specified Role in storage.
     * PUT/PATCH /staffUsers/{id}
     *
     * @param int $id
     * @param UpdateRoleAPIRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, UpdateStaffUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var StaffUser $staffUser */
        $staffUser = $this->staffUserRepository->find($id);

        $staffUser = $this->staffUserRepository->update($input, $id);

        return redirect('/avanya-vip-portal/staff-users')->with('message', 'Staff user updated successfully.');
    }

    public function updateStaffPassword($id, Request $request)
    {
        /** @var StaffUser $staffUser */
        $staffUser = $this->staffUserRepository->find($id);

        $input = $request->all();
        if (!empty($input['password'])) {
            $request->validate([
                'password' => 'required_with:password_confirmation|same:password_confirmation',
            ]);

            $input['password'] = Hash::make($input['password']);

        } else {
            $input['password'] = $staffUser->password;
        }

        $staffUser = $this->staffUserRepository->update($input, $id);

        return redirect('/avanya-vip-portal/staff-users')->with('message', 'Staff user password updated successfully.');

    }

    /**
     * Remove the specified Role from storage.
     * DELETE /staffUsers/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var StaffUser $staffUser */
        $staffUser = $this->staffUserRepository->find($id);

        $staffUser->delete();

        return redirect('avanya-vip-portal/staff-users')->with('message', 'Staff user deleted successfully.');
    }
}
