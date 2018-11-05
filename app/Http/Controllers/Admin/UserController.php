<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UserDataTable;
use App\Helper\BreadcrumbsRegister;
use App\Helper\Utils;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Repositories\Admin\RoleRepository;
use App\Repositories\Admin\UserRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\UserShowroomRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    /** ModelName */
    private $ModelName;

    /** ModelName */
    private $BreadCrumbName;

    /** @var  RoleRepository */
    private $roleRepository;

    /** @var  UserShowroomRepository */
    private $showroomRepository;

    public function __construct(UserRepository $userRepo, RoleRepository $roleRepo, UserShowroomRepository $showroomRepo)
    {
        $this->userRepository = $userRepo;
        $this->roleRepository = $roleRepo;
        $this->showroomRepository = $showroomRepo;
        $this->ModelName = 'users';
        $this->BreadCrumbName = 'Users';
    }

    /**
     * Display a listing of the User.
     *
     * @param UserDataTable $userDataTable
     * @return Response
     */
    public function index(UserDataTable $userDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return $userDataTable->render('admin.users.index');

    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        $roles = $this->roleRepository->all()->where('id', '!=', '1')->pluck('display_name', 'id')->all();
        return view('admin.users.create')->with('roles', $roles);
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = $this->userRepository->create($input);

        Flash::success('User saved successfully.');
        return redirect(route('admin.users.index'));
    }

    /**
     * Display the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');
            return redirect(route('admin.users.index'));
        }
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $user);
        return view('admin.users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');
            return redirect(route('admin.users.index'));
        }

        $roles = $this->roleRepository->all()->where('id', '!=', '1')->pluck('display_name', 'id')->all();
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $user);
        return view('admin.users.edit')->with(['user' => $user, 'roles' => $roles]);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');
            return redirect(route('admin.users.index'));
        }

        $data = $request->all();
        unset($data['email']);
        if ($request->has('password') && $request->get('password', null) === null) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $selectedRoles = [];
        if ($request->has('roles') || $request->get('roles', null) !== null) {
            $selectedRoles = $request->get('roles');
            unset($data['roles']);

            $existingRoles = $user->roles->pluck('id')->all();
            $newRoles = array_diff($selectedRoles, $existingRoles);
            $rolesToBeDeleted = array_diff($existingRoles, $selectedRoles);

            foreach ($newRoles as $newRole) {
                $this->userRepository->attachRole($user->id, $newRole);
            }

            foreach ($rolesToBeDeleted as $roleToBeDeleted) {
                $this->userRepository->detachRole($user->id, $roleToBeDeleted);
            }
        }

        // Media Data
        if ($request->hasFile('image')) {
//            $media = [];
            $mediaFile = $request->file('image');
            $data['image'] = Storage::putFile('media_files', $mediaFile);
//            $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];
//            foreach ($mediaFiles as $mediaFile) {
//                $media[] = $this->handlePicture($mediaFile);
//                $media[] = Utils::handlePicture($mediaFile);
//            }
//            $data['image'] = $media[0]['filename'];
        }
        $user->details->update($data);

        $user = $this->userRepository->update($data, $id);

        if (isset($request->showroom)) {
            $this->showroomRepository->updateRecord($request, $id);
        }

        Flash::success('User updated successfully.');
        if ($user->hasRole('showroom-owner')) {
            return redirect(route('admin.users.profile'));
        }
        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->findWithoutFail($id);
        if (empty($user)) {
            Flash::error('User not found');
            return redirect(route('admin.users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('User deleted successfully.');
        return redirect(route('admin.users.index'));
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function profile()
    {
        $user = Auth::user();
        if (empty($user)) {
            Flash::error('User not found');
            return redirect(route('admin.users.index'));
        }

        $this->BreadCrumbName = 'Profile';
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        if ($user->hasRole('showroom-owner')) {
            return view('admin.showroom.profile')->with('user', $user);
        }
        return view('admin.users.edit')->with('user', $user);
    }
}