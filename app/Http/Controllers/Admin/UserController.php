<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UserDataTable;
use App\Helper\BreadcrumbsRegister;
use App\Helper\Utils;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateShowroomProfileRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\CarInteraction;
use App\Models\NewsInteraction;
use App\Models\Role;
use App\Models\TradeInCar;
use App\Models\User;
use App\Models\UserDetail;
use App\Repositories\Admin\CarInteractionRepository;
use App\Repositories\Admin\RoleRepository;
use App\Repositories\Admin\UserdetailRepository;
use App\Repositories\Admin\UserRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\UserShowroomRepository;
use Illuminate\Http\Request;
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

    /** @var  CarInteractionRepository */
    private $carInteractionRepository;

    /** @var  UserdetailRepository */
    private $userDetailRepository;

    public function __construct(UserRepository $userRepo, UserdetailRepository $userDetailRepo, RoleRepository $roleRepo, UserShowroomRepository $showroomRepo, CarInteractionRepository $carInteractionRepo)
    {
        $this->userRepository = $userRepo;
        $this->roleRepository = $roleRepo;
        $this->showroomRepository = $showroomRepo;
        $this->carInteractionRepository = $carInteractionRepo;
        $this->userDetailRepository = $userDetailRepo;
        $this->ModelName = 'users';
        $this->BreadCrumbName = 'Users';
    }

    /**
     * Display a listing of the User.
     *
     * @param Request $request
     * @param UserDataTable $userDataTable
     * @return Response
     */
    public function index(Request $request, UserDataTable $userDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        $data = $request->all();
        $title = '';
        if ($data) {
            if (isset($data['type'])) {
                if ($data['type'] == CarInteraction::TYPE_FAVORITE) {
                    $title = "User Favorites";
                } elseif ($data['type'] == CarInteraction::TYPE_VIEW) {
                    $title = 'User Views';
                } elseif ($data['type'] == CarInteraction::TYPE_CLICK_CATEGORY) {
                    $title = 'User Click on Category';
                } elseif ($data['type'] == NewsInteraction::TYPE_VIEW) {
                    $title = 'User Views News';
                } elseif ($data['type'] == NewsInteraction::TYPE_LIKE) {
                    $title = 'User Like News';
                } elseif ($data['type'] == NewsInteraction::TYPE_COMMENT) {
                    $title = 'User Comment News';
                }
            }

            return $userDataTable->interactionList($data)->render('admin.users.index', ['title' => $title]);
        } else {
            return $userDataTable->render('admin.users.index', ['title' => $this->BreadCrumbName]);
        }
//        return $userDataTable->render('admin.users.index');
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
        return view('admin.users.create')->with([
            'roles'       => $roles,
            'DEALER_TYPE' => User::$DEALER_TYPE
        ]);
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

        $data['user_id'] = $user->id;
        $data['first_name'] = $user->name;
        $data['dealer_type'] = $input['dealer_type'] ?? null;
        $data['dealer_type'] = $input['dealer_type'] == 10 ? 'Official Dealer' : 'Market Dealer';
        $this->userRepository->attachRole($user->id, Role::SHOWROOM_OWNER_ROLE);
        $userDetail = $this->userDetailRepository->create($data);

        $showroomDeatails['user_id'] = $user->id;
        $showroomDeatails['name'] = $user->name . "'s Showroom'";
        $showroomDeatails = $this->showroomRepository->create($showroomDeatails);

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
        $data = [];
        /*$data['view'] = $this->carInteractionRepository->findWhere(['user_id' => $user->id, 'type' => CarInteraction::TYPE_VIEW])->count();

        $data['like'] = $this->carInteractionRepository->findWhere(['user_id' => $user->id, 'type' => CarInteraction::TYPE_LIKE])->count();

        $data['favorite'] = $this->carInteractionRepository->findWhere(['user_id' => $user->id, 'type' => CarInteraction::TYPE_FAVORITE])->count();*/

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $user);
        return view('admin.users.show')->with(['user' => $user, 'data' => $data]);
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
        return view('admin.users.edit')->with([
            'user'        => $user,
            'roles'       => $roles,
            'DEALER_TYPE' => User::$DEALER_TYPE]);
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

        /*$selectedRoles = [];
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
        }*/

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

        $data['first_name'] = $data['name'];
        $user->details->update($data);
        unset($data['first_name']);
        $user = $this->userRepository->update($data, $id);

        if (isset($request->showroom)) {
            $this->showroomRepository->updateRecord($request, $id);
        }

        if (Auth::user()->hasRole('showroom-owner')) {
            Flash::success('Profile Updated successfully.');
            return redirect(route('admin.users.profile'));
        }

        if ($id == Auth::id()) {
            Flash::success('Profile Updated successfully.');
            $redirectTo = redirect(route('admin.dashboard'));
        } else {
            Flash::success('User updated successfully.');
            $redirectTo = redirect(route('admin.users.index'));
        }
        return $redirectTo;
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

        if ($user->cars->count() > 0){
            if (TradeInCar::whereIn('owner_car_id', $user->cars->pluck('id')->toArray())->orWhereIn('customer_car_id', $user->cars->pluck('id')->toArray())->orWhere('user_id', $id)->count() > 0) {
                Flash::error('Car cannot be deleted, Trade request found');
                return redirect(route('admin.users.index'));
            }
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

    public function updateShowroomProfile($id, UpdateShowroomProfileRequest $request)
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

        // Media Data
        if ($request->hasFile('image')) {
            $mediaFile = $request->file('image');
            $data['image'] = Storage::putFile('media_files', $mediaFile);
        }

        $data['first_name'] = $data['name'];
        $user->details->update($data);
        unset($data['first_name']);
        $user = $this->userRepository->update($data, $id);

        $this->showroomRepository->updateRecordNew($request, $id);

        if ($user->hasRole('showroom-owner')) {
            Flash::success('Profile Updated successfully.');
            return redirect(route('admin.users.profile'));
        }

    }

}