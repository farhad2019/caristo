<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UserDataTable;
use App\Helper\BreadcrumbsRegister;
use App\Helper\Utils;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateShowroomProfileRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\CarInteraction;
use App\Models\News;
use App\Models\NewsInteraction;
use App\Models\NotificationUser;
use App\Models\Role;
use App\Models\TradeInCar;
use App\Models\User;
use App\Models\UserDetail;
use App\Repositories\Admin\CarBrandRepository;
use App\Repositories\Admin\CarInteractionRepository;
use App\Repositories\Admin\CarRepository;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\NewsRepository;
use App\Repositories\Admin\RegionRepository;
use App\Repositories\Admin\RoleRepository;
use App\Repositories\Admin\UserdetailRepository;
use App\Repositories\Admin\UserRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\UserShowroomRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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

    /**
     * @var RegionRepository
     */
    private $regionRepository;

    /**
     * @var NewsRepository
     */
    private $newsRepository;

    /**
     * @var CarRepository
     */
    private $carRepository;

    /**
     * @var CarBrandRepository
     */
    private $brandRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepo
     * @param UserdetailRepository $userDetailRepo
     * @param NewsRepository $newsRepository
     * @param RoleRepository $roleRepo
     * @param RegionRepository $regionRepository
     * @param UserShowroomRepository $showroomRepo
     * @param CarRepository $carRepository
     * @param CarInteractionRepository $carInteractionRepo
     * @param CarBrandRepository $brandRepo
     * @param CategoryRepository $categoryRepo
     */
    public function __construct(UserRepository $userRepo, UserdetailRepository $userDetailRepo, NewsRepository $newsRepository, RoleRepository $roleRepo, RegionRepository $regionRepository, UserShowroomRepository $showroomRepo, CarRepository $carRepository, CarInteractionRepository $carInteractionRepo, CarBrandRepository $brandRepo, CategoryRepository $categoryRepo)
    {
        $this->userRepository = $userRepo;
        $this->roleRepository = $roleRepo;
        $this->regionRepository = $regionRepository;
        $this->showroomRepository = $showroomRepo;
        $this->carInteractionRepository = $carInteractionRepo;
        $this->userDetailRepository = $userDetailRepo;
        $this->newsRepository = $newsRepository;
        $this->carRepository = $carRepository;
        $this->brandRepository = $brandRepo;
        $this->categoryRepository = $categoryRepo;
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

            if (isset($data['news_id'])) {
                $news = $this->newsRepository->findWithoutFail($data['news_id']);
                $second_tile = "News : " . $news['headline'];

            } else if (isset($data['car_id'])) {
                if ($data['type'] == CarInteraction::TYPE_CLICK_CATEGORY) {
                    $car = $this->categoryRepository->findWithoutFail($data['car_id']);
                    $second_tile = "Category : " . $car['name'];
                } else {
                    $car = $this->carRepository->findWithoutFail($data['car_id']);
                    $second_tile = "Car : " . $car['name'];
                }
            } else {
                $second_tile = "";
            }

            return $userDataTable->interactionList($data)->render('admin.users.index', ['title' => $title, 'secondtitle' => $second_tile]);
        } else {
            return $userDataTable->render('admin.users.index', ['title' => $this->BreadCrumbName]);
        }
//        return $userDataTable->render('admin.users.index');
    }

    /**
     * Show the form for creating a new User.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        $roles = $this->roleRepository->all()->where('id', '!=', '1')->pluck('display_name', 'id')->all();
        $regions = $this->regionRepository->all()->pluck('name', 'id')->all();
        $brands = $this->brandRepository->all()->pluck('name', 'id')->all();

        return view('admin.users.create')->with([
            'roles'       => $roles,
            'regions'     => $regions,
            'brands'      => $brands,
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
        $data['dealer_type'] = isset($input['dealer_type']) ? $input['dealer_type'] : 10;
        $data['dealer_type_text'] = $input['dealer_type'] == 10 ? 'Official Dealer' : 'Market Dealer';
        $data['region_id'] = isset($input['region_id']) ? $input['region_id'] : null;
        $data['limit_for_featured_cars'] = isset($input['limit_for_featured_cars']) ? $input['limit_for_featured_cars'] : null;
        $data['limit_for_cars'] = isset($input['limit_for_cars']) ? $input['limit_for_cars'] : null;
        $data['expiry_date'] = isset($input['expiry_date']) ? $input['expiry_date'] : null;

        $this->userRepository->attachRole($user->id, Role::SHOWROOM_OWNER_ROLE);
        $user->brands()->attach($input['brand_ids']);
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');
            return redirect(route('admin.users.index'));
        }

        $roles = $this->roleRepository->all()->where('id', '!=', '1')->pluck('display_name', 'id')->all();
        $regions = $this->regionRepository->all()->pluck('name', 'id')->all();
        $brands = $this->brandRepository->all()->pluck('name', 'id')->all();
        $nationalities = [
            'Afghan'                    => 'Afghan',
            'Albanian'                  => 'Albanian',
            'Algerian'                  => 'Algerian',
            'American'                  => 'American',
            'Andorran'                  => 'Andorran',
            'Angolan'                   => 'Angolan',
            'Antiguans'                 => 'Antiguans',
            'Argentinean'               => 'Argentinean',
            'Armenian'                  => 'Armenian',
            'Australian'                => 'Australian',
            'Austrian'                  => 'Austrian',
            'Azerbaijani'               => 'Azerbaijani',
            'Bahamian'                  => 'Bahamian',
            'Bahraini'                  => 'Bahraini',
            'Bangladeshi'               => 'Bangladeshi',
            'Barbadian'                 => 'Barbadian',
            'Barbudans'                 => 'Barbudans',
            'Batswana'                  => 'Batswana',
            'Belarusian'                => 'Belarusian',
            'Belgian'                   => 'Belgian',
            'Belizean'                  => 'Belizean',
            'Beninese'                  => 'Beninese',
            'Bhutanese'                 => 'Bhutanese',
            'Bolivian'                  => 'Bolivian',
            'Bosnian'                   => 'Bosnian',
            'Brazilian'                 => 'Brazilian',
            'British'                   => 'British',
            'Bruneian'                  => 'Bruneian',
            'Bulgarian'                 => 'Bulgarian',
            'Burkinabe'                 => 'Burkinabe',
            'Burmese'                   => 'Burmese',
            'Burundian'                 => 'Burundian',
            'Cambodian'                 => 'Cambodian',
            'Cameroonian'               => 'Cameroonian',
            'Canadian'                  => 'Canadian',
            'Cape Verdean'              => 'Cape Verdean',
            'Central African'           => 'Central African',
            'Chadian'                   => 'Chadian',
            'Chilean'                   => 'Chilean',
            'Chinese'                   => 'Chinese',
            'Colombian'                 => 'Colombian',
            'Comoran'                   => 'Comoran',
            'Congolese'                 => 'Congolese',
            'Costa Rican'               => 'Costa Rican',
            'Croatian'                  => 'Croatian',
            'Cuban'                     => 'Cuban',
            'Cypriot'                   => 'Cypriot',
            'Czech'                     => 'Czech',
            'Danish'                    => 'Danish',
            'Djibouti'                  => 'Djibouti',
            'Dominican'                 => 'Dominican',
            'Dutch'                     => 'Dutch',
            'East Timorese'             => 'East Timorese',
            'Ecuadorean'                => 'Ecuadorean',
            'Egyptian'                  => 'Egyptian',
            'Emirian'                   => 'Emirian',
            'Equatorial Guinean'        => 'Equatorial Guinean',
            'Eritrean'                  => 'Eritrean',
            'Estonian'                  => 'Estonian',
            'Ethiopian'                 => 'Ethiopian',
            'Fijian'                    => 'Fijian',
            'Filipino'                  => 'Filipino',
            'Finnish'                   => 'Finnish',
            'French'                    => 'French',
            'Gabonese'                  => 'Gabonese',
            'Gambian'                   => 'Gambian',
            'Georgian'                  => 'Georgian',
            'German'                    => 'German',
            'Ghanaian'                  => 'Ghanaian',
            'Greek'                     => 'Greek',
            'Grenadian'                 => 'Grenadian',
            'Guatemalan'                => 'Guatemalan',
            'Guinea--Bissauan'          => 'Guinea-Bissauan',
            'Guinean'                   => 'Guinean',
            'Guyanese'                  => 'Guyanese',
            'Haitian'                   => 'Haitian',
            'Herzegovinian'             => 'Herzegovinian',
            'Honduran'                  => 'Honduran',
            'Hungarian'                 => 'Hungarian',
            'Icelander'                 => 'Icelander',
            'Indian'                    => 'Indian',
            'Indonesian'                => 'Indonesian',
            'Iranian'                   => 'Iranian',
            'Iraqi'                     => 'Iraqi',
            'Irish'                     => 'Irish',
            'Israeli'                   => 'Israeli',
            'Italian'                   => 'Italian',
            'Ivorian'                   => 'Ivorian',
            'Jamaican'                  => 'Jamaican',
            'Japanese'                  => 'Japanese',
            'Jordanian'                 => 'Jordanian',
            'Kazakhstani'               => 'Kazakhstani',
            'Kenyan'                    => 'Kenyan',
            'Kittian and Nevisian'      => 'Kittian and Nevisian',
            'Kuwaiti'                   => 'Kuwaiti',
            'Kyrgyz'                    => 'Kyrgyz',
            'Laotian'                   => 'Laotian',
            'Latvian'                   => 'Latvian',
            'Lebanese'                  => 'Lebanese',
            'Liberian'                  => 'Liberian',
            'Libyan'                    => 'Libyan',
            'Liechtensteiner'           => 'Liechtensteiner',
            'Lithuanian'                => 'Lithuanian',
            'Luxembourger'              => 'Luxembourger',
            'Macedonian'                => 'Macedonian',
            'Malagasy'                  => 'Malagasy',
            'Malawian'                  => 'Malawian',
            'Malaysian'                 => 'Malaysian',
            'Maldivan'                  => 'Maldivan',
            'Malian'                    => 'Malian',
            'Maltese'                   => 'Maltese',
            'Marshallese'               => 'Marshallese',
            'Mauritanian'               => 'Mauritanian',
            'Mauritian'                 => 'Mauritian',
            'Mexican'                   => 'Mexican',
            'Micronesian'               => 'Micronesian',
            'Moldovan'                  => 'Moldovan',
            'Monacan'                   => 'Monacan',
            'Mongolian'                 => 'Mongolian',
            'Moroccan'                  => 'Moroccan',
            'Mosotho'                   => 'Mosotho',
            'Motswana'                  => 'Motswana',
            'Mozambican'                => 'Mozambican',
            'Namibian'                  => 'Namibian',
            'Nauruan'                   => 'Nauruan',
            'Nepalese'                  => 'Nepalese',
            'Netherlander'              => 'Netherlander',
            'New Zealander'             => 'New Zealander',
            'Ni-Vanuatu'                => 'Ni-Vanuatu',
            'Nicaraguan'                => 'Nicaraguan',
            'Nigerian'                  => 'Nigerian',
            'Nigerien'                  => 'Nigerien',
            'North Korean'              => 'North Korean',
            'Northern Irish'            => 'Northern Irish',
            'Norwegian'                 => 'Norwegian',
            'Omani'                     => 'Omani',
            'Pakistani'                 => 'Pakistani',
            'Palauan'                   => 'Palauan',
            'Panamanian'                => 'Panamanian',
            'Papua New Guinean'         => 'Papua New Guinean',
            'Paraguayan'                => 'Paraguayan',
            'Peruvian'                  => 'Peruvian',
            'Polish'                    => 'Polish',
            'Portuguese'                => 'Portuguese',
            'Qatari'                    => 'Qatari',
            'Romanian'                  => 'Romanian',
            'Russian'                   => 'Russian',
            'Rwandan'                   => 'Rwandan',
            'Saint Lucian'              => 'Saint Lucian',
            'Salvadoran'                => 'Salvadoran',
            'Samoan'                    => 'Samoan',
            'San Marinese'              => 'San Marinese',
            'Sao Tomean'                => 'Sao Tomean',
            'Saudi'                     => 'Saudi',
            'Scottish'                  => 'Scottish',
            'Senegalese'                => 'Senegalese',
            'Serbian'                   => 'Serbian',
            'Seychellois'               => 'Seychellois',
            'Sierra Leonean'            => 'Sierra Leonean',
            'Singaporean'               => 'Singaporean',
            'Slovakian'                 => 'Slovakian',
            'Slovenian'                 => 'Slovenian',
            'Solomon Islander'          => 'Solomon Islander',
            'Somali'                    => 'Somali',
            'South African'             => 'South African',
            'South Korean'              => 'South Korean',
            'Spanish'                   => 'Spanish',
            'Sri Lankan'                => 'Sri Lankan',
            'Sudanese'                  => 'Sudanese',
            'Surinamer'                 => 'Surinamer',
            'Swazi'                     => 'Swazi',
            'Swedish'                   => 'Swedish',
            'Swiss'                     => 'Swiss',
            'Syrian'                    => 'Syrian',
            'Taiwanese'                 => 'Taiwanese',
            'Tajik'                     => 'Tajik',
            'Tanzanian'                 => 'Tanzanian',
            'Thai'                      => 'Thai',
            'Togolese'                  => 'Togolese',
            'Tongan'                    => 'Tongan',
            'Trinidadian or Tobagonian' => 'Trinidadian or Tobagonian',
            'Tunisian'                  => 'Tunisian',
            'Turkish'                   => 'Turkish',
            'Tuvaluan'                  => 'Tuvaluan',
            'Ugandan'                   => 'Ugandan',
            'Ukrainian'                 => 'Ukrainian',
            'Uruguayan'                 => 'Uruguayan',
            'Uzbekistani'               => 'Uzbekistani',
            'Venezuelan'                => 'Venezuelan',
            'Vietnamese'                => 'Vietnamese',
            'Welsh'                     => 'Welsh',
            'Yemenite'                  => 'Yemenite',
            'Zambian'                   => 'Zambian',
            'Zimbabwean'                => 'Zimbabwean'
        ];

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $user);
        return view('admin.users.edit')->with([
            'user'          => $user,
            'roles'         => $roles,
            'regions'       => $regions,
            'brands'        => $brands,
            'nationalities' => $nationalities,
            'DEALER_TYPE'   => User::$DEALER_TYPE,
            'gender'        => UserDetail::$GENDER
        ]);
    }

    /**
     * Update the specified User in storage.
     *
     * @param  int $id
     * @param UpdateUserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');
            return redirect(route('admin.users.index'));
        }

        $data = $request->all();
        if ($user->hasRole('showroom-owner')) {
            if ($data['limit_for_cars'] < $user->cars()->count()) {
                return Redirect::back()->withErrors(['Car limit should be greater than user cars. (' . $user->cars()->count() . ')']);
            }
            if ($data['limit_for_featured_cars'] < $user->cars()->where('is_featured', 1)->count()) {
                return Redirect::back()->withErrors(['Featured car limit should be greater than user featured cars. (' . $user->cars()->where('is_featured', 1)->count() . ')']);
            }

            $user->brands()->sync($data['brand_ids']);
        }

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

        if ($user->cars->count() > 0) {
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();
        if (empty($user)) {
            Flash::error('User not found');
            return redirect(route('admin.users.index'));
        }

        $regions = $this->regionRepository->all()->pluck('name', 'id')->all();
        $nationalities = [
            'Afghan'                    => 'Afghan',
            'Albanian'                  => 'Albanian',
            'Algerian'                  => 'Algerian',
            'American'                  => 'American',
            'Andorran'                  => 'Andorran',
            'Angolan'                   => 'Angolan',
            'Antiguans'                 => 'Antiguans',
            'Argentinean'               => 'Argentinean',
            'Armenian'                  => 'Armenian',
            'Australian'                => 'Australian',
            'Austrian'                  => 'Austrian',
            'Azerbaijani'               => 'Azerbaijani',
            'Bahamian'                  => 'Bahamian',
            'Bahraini'                  => 'Bahraini',
            'Bangladeshi'               => 'Bangladeshi',
            'Barbadian'                 => 'Barbadian',
            'Barbudans'                 => 'Barbudans',
            'Batswana'                  => 'Batswana',
            'Belarusian'                => 'Belarusian',
            'Belgian'                   => 'Belgian',
            'Belizean'                  => 'Belizean',
            'Beninese'                  => 'Beninese',
            'Bhutanese'                 => 'Bhutanese',
            'Bolivian'                  => 'Bolivian',
            'Bosnian'                   => 'Bosnian',
            'Brazilian'                 => 'Brazilian',
            'British'                   => 'British',
            'Bruneian'                  => 'Bruneian',
            'Bulgarian'                 => 'Bulgarian',
            'Burkinabe'                 => 'Burkinabe',
            'Burmese'                   => 'Burmese',
            'Burundian'                 => 'Burundian',
            'Cambodian'                 => 'Cambodian',
            'Cameroonian'               => 'Cameroonian',
            'Canadian'                  => 'Canadian',
            'Cape Verdean'              => 'Cape Verdean',
            'Central African'           => 'Central African',
            'Chadian'                   => 'Chadian',
            'Chilean'                   => 'Chilean',
            'Chinese'                   => 'Chinese',
            'Colombian'                 => 'Colombian',
            'Comoran'                   => 'Comoran',
            'Congolese'                 => 'Congolese',
            'Costa Rican'               => 'Costa Rican',
            'Croatian'                  => 'Croatian',
            'Cuban'                     => 'Cuban',
            'Cypriot'                   => 'Cypriot',
            'Czech'                     => 'Czech',
            'Danish'                    => 'Danish',
            'Djibouti'                  => 'Djibouti',
            'Dominican'                 => 'Dominican',
            'Dutch'                     => 'Dutch',
            'East Timorese'             => 'East Timorese',
            'Ecuadorean'                => 'Ecuadorean',
            'Egyptian'                  => 'Egyptian',
            'Emirian'                   => 'Emirian',
            'Equatorial Guinean'        => 'Equatorial Guinean',
            'Eritrean'                  => 'Eritrean',
            'Estonian'                  => 'Estonian',
            'Ethiopian'                 => 'Ethiopian',
            'Fijian'                    => 'Fijian',
            'Filipino'                  => 'Filipino',
            'Finnish'                   => 'Finnish',
            'French'                    => 'French',
            'Gabonese'                  => 'Gabonese',
            'Gambian'                   => 'Gambian',
            'Georgian'                  => 'Georgian',
            'German'                    => 'German',
            'Ghanaian'                  => 'Ghanaian',
            'Greek'                     => 'Greek',
            'Grenadian'                 => 'Grenadian',
            'Guatemalan'                => 'Guatemalan',
            'Guinea--Bissauan'          => 'Guinea-Bissauan',
            'Guinean'                   => 'Guinean',
            'Guyanese'                  => 'Guyanese',
            'Haitian'                   => 'Haitian',
            'Herzegovinian'             => 'Herzegovinian',
            'Honduran'                  => 'Honduran',
            'Hungarian'                 => 'Hungarian',
            'Icelander'                 => 'Icelander',
            'Indian'                    => 'Indian',
            'Indonesian'                => 'Indonesian',
            'Iranian'                   => 'Iranian',
            'Iraqi'                     => 'Iraqi',
            'Irish'                     => 'Irish',
            'Israeli'                   => 'Israeli',
            'Italian'                   => 'Italian',
            'Ivorian'                   => 'Ivorian',
            'Jamaican'                  => 'Jamaican',
            'Japanese'                  => 'Japanese',
            'Jordanian'                 => 'Jordanian',
            'Kazakhstani'               => 'Kazakhstani',
            'Kenyan'                    => 'Kenyan',
            'Kittian and Nevisian'      => 'Kittian and Nevisian',
            'Kuwaiti'                   => 'Kuwaiti',
            'Kyrgyz'                    => 'Kyrgyz',
            'Laotian'                   => 'Laotian',
            'Latvian'                   => 'Latvian',
            'Lebanese'                  => 'Lebanese',
            'Liberian'                  => 'Liberian',
            'Libyan'                    => 'Libyan',
            'Liechtensteiner'           => 'Liechtensteiner',
            'Lithuanian'                => 'Lithuanian',
            'Luxembourger'              => 'Luxembourger',
            'Macedonian'                => 'Macedonian',
            'Malagasy'                  => 'Malagasy',
            'Malawian'                  => 'Malawian',
            'Malaysian'                 => 'Malaysian',
            'Maldivan'                  => 'Maldivan',
            'Malian'                    => 'Malian',
            'Maltese'                   => 'Maltese',
            'Marshallese'               => 'Marshallese',
            'Mauritanian'               => 'Mauritanian',
            'Mauritian'                 => 'Mauritian',
            'Mexican'                   => 'Mexican',
            'Micronesian'               => 'Micronesian',
            'Moldovan'                  => 'Moldovan',
            'Monacan'                   => 'Monacan',
            'Mongolian'                 => 'Mongolian',
            'Moroccan'                  => 'Moroccan',
            'Mosotho'                   => 'Mosotho',
            'Motswana'                  => 'Motswana',
            'Mozambican'                => 'Mozambican',
            'Namibian'                  => 'Namibian',
            'Nauruan'                   => 'Nauruan',
            'Nepalese'                  => 'Nepalese',
            'Netherlander'              => 'Netherlander',
            'New Zealander'             => 'New Zealander',
            'Ni-Vanuatu'                => 'Ni-Vanuatu',
            'Nicaraguan'                => 'Nicaraguan',
            'Nigerian'                  => 'Nigerian',
            'Nigerien'                  => 'Nigerien',
            'North Korean'              => 'North Korean',
            'Northern Irish'            => 'Northern Irish',
            'Norwegian'                 => 'Norwegian',
            'Omani'                     => 'Omani',
            'Pakistani'                 => 'Pakistani',
            'Palauan'                   => 'Palauan',
            'Panamanian'                => 'Panamanian',
            'Papua New Guinean'         => 'Papua New Guinean',
            'Paraguayan'                => 'Paraguayan',
            'Peruvian'                  => 'Peruvian',
            'Polish'                    => 'Polish',
            'Portuguese'                => 'Portuguese',
            'Qatari'                    => 'Qatari',
            'Romanian'                  => 'Romanian',
            'Russian'                   => 'Russian',
            'Rwandan'                   => 'Rwandan',
            'Saint Lucian'              => 'Saint Lucian',
            'Salvadoran'                => 'Salvadoran',
            'Samoan'                    => 'Samoan',
            'San Marinese'              => 'San Marinese',
            'Sao Tomean'                => 'Sao Tomean',
            'Saudi'                     => 'Saudi',
            'Scottish'                  => 'Scottish',
            'Senegalese'                => 'Senegalese',
            'Serbian'                   => 'Serbian',
            'Seychellois'               => 'Seychellois',
            'Sierra Leonean'            => 'Sierra Leonean',
            'Singaporean'               => 'Singaporean',
            'Slovakian'                 => 'Slovakian',
            'Slovenian'                 => 'Slovenian',
            'Solomon Islander'          => 'Solomon Islander',
            'Somali'                    => 'Somali',
            'South African'             => 'South African',
            'South Korean'              => 'South Korean',
            'Spanish'                   => 'Spanish',
            'Sri Lankan'                => 'Sri Lankan',
            'Sudanese'                  => 'Sudanese',
            'Surinamer'                 => 'Surinamer',
            'Swazi'                     => 'Swazi',
            'Swedish'                   => 'Swedish',
            'Swiss'                     => 'Swiss',
            'Syrian'                    => 'Syrian',
            'Taiwanese'                 => 'Taiwanese',
            'Tajik'                     => 'Tajik',
            'Tanzanian'                 => 'Tanzanian',
            'Thai'                      => 'Thai',
            'Togolese'                  => 'Togolese',
            'Tongan'                    => 'Tongan',
            'Trinidadian or Tobagonian' => 'Trinidadian or Tobagonian',
            'Tunisian'                  => 'Tunisian',
            'Turkish'                   => 'Turkish',
            'Tuvaluan'                  => 'Tuvaluan',
            'Ugandan'                   => 'Ugandan',
            'Ukrainian'                 => 'Ukrainian',
            'Uruguayan'                 => 'Uruguayan',
            'Uzbekistani'               => 'Uzbekistani',
            'Venezuelan'                => 'Venezuelan',
            'Vietnamese'                => 'Vietnamese',
            'Welsh'                     => 'Welsh',
            'Yemenite'                  => 'Yemenite',
            'Zambian'                   => 'Zambian',
            'Zimbabwean'                => 'Zimbabwean'
        ];
        $this->BreadCrumbName = 'Profile';
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        if ($user->hasRole('showroom-owner')) {
            $notifications = Auth::user()->notifications()->where('status', NotificationUser::STATUS_DELIVERED)->get();
            return view('admin.showroom.profile')->with([
                'user'          => $user,
                'regions'       => $regions,
                'nationalities' => $nationalities,
                'notifications' => $notifications,
                'gender'        => UserDetail::$GENDER
            ]);
        }
        return view('admin.users.edit')->with([
            'user'    => $user,
            'regions' => $regions,
            'gender'  => UserDetail::$GENDER
        ]);
    }

    /**
     * @param $id
     * @param UpdateShowroomProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
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