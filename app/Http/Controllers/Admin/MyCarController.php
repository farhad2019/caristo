<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\MyCarDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateMyCarRequest;
use App\Models\CarRegion;
use App\Models\MyCar;
use App\Models\TradeInCar;
use App\Repositories\Admin\CarAttributeRepository;
use App\Repositories\Admin\CarBrandRepository;
use App\Repositories\Admin\CarFeatureRepository;
use App\Repositories\Admin\CarModelRepository;
use App\Repositories\Admin\CarTypeRepository;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\EngineTypeRepository;
use App\Repositories\Admin\MyCarRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Admin\RegionalSpecificationRepository;
use App\Repositories\Admin\RegionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class MyCarController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  MyCarRepository */
    private $myCarRepository;

    /** @var  CategoryRepository */
    private $categoryRepository;

    /** @var  CarBrandRepository */
    private $brandRepository;

    /** @var  RegionalSpecificationRepository */
    private $regionalSpecRepository;

    /** @var  EngineTypeRepository */
    private $engineTypeRepository;

    /** @var  CarAttributeRepository */
    private $attributeRepository;

    /** @var  CarTypeRepository */
    private $carTypeRepository;

    /** @var  CarModelRepository */
    private $modelRepository;

    /** @var  CarFeatureRepository */
    private $featureRepository;

    /** @var  RegionRepository */
    private $regionRepository;

    public function __construct(MyCarRepository $myCarRepo, CategoryRepository $categoryRepo, CarBrandRepository $brandRepo, RegionalSpecificationRepository $regionalSpecRepo, EngineTypeRepository $engineTypeRepo, CarAttributeRepository $attributeRepo, CarTypeRepository $carTypeRepo, CarModelRepository $modelRepo, CarFeatureRepository $featureRepo, RegionRepository $regionRepo)
    {
        $this->myCarRepository = $myCarRepo;
        $this->categoryRepository = $categoryRepo;
        $this->brandRepository = $brandRepo;
        $this->regionalSpecRepository = $regionalSpecRepo;
        $this->engineTypeRepository = $engineTypeRepo;
        $this->attributeRepository = $attributeRepo;
        $this->carTypeRepository = $carTypeRepo;
        $this->modelRepository = $modelRepo;
        $this->featureRepository = $featureRepo;
        $this->regionRepository = $regionRepo;
        $this->ModelName = 'myCars';
        $this->BreadCrumbName = 'MyCar';
    }

    /**
     * Display a listing of the MyCar.
     *
     * @param MyCarDataTable $myCarDataTable
     * @return Response
     */
    public function index(MyCarDataTable $myCarDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        /*if (Auth::user()->hasRole('showroom-owner')) {
            return view('admin.showroom.profile')->with('user', Auth::user());
        }*/
        return $myCarDataTable->render('admin.my_cars.index');
    }

    /**
     * Show the form for creating a new MyCar.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->cars()->count() >= $user->details->limit_for_cars ) {
            Flash::error('Your cars have reached to the limit.(' . $user->details->limit_for_cars . ')');
            return redirect(route('admin.myCars.index'));
        }
        if ($user->details->expiry_date > now()->format('Y-m-d')) {
            Flash::error('Your cars limit has been expired, contact admin');
            return redirect(route('admin.myCars.index'));
        }
        $brands = $this->brandRepository->all()->pluck('name', 'id');
        $categories = $this->categoryRepository->getCarCategories()->pluck('name', 'id');

        $regional_specs = $this->regionalSpecRepository->all()->pluck('name', 'id');
        $engineType = $this->engineTypeRepository->all()->pluck('name', 'id');
        $attributes = $this->attributeRepository->all();
        $features = $this->featureRepository->all();
        $carTypes = $this->carTypeRepository->getRootTypes()->pluck('name', 'id');
        $carModels = $this->modelRepository->all()->pluck('name', 'id');
        $regions = $this->regionRepository->orderBy('created_at', 'ASC')->all()->pluck('name', 'id');
        $years = ['1950' => "1950",
            '1951' => "1951",
            '1952' => "1952",
            '1953' => "1953",
            '1954' => "1954",
            '1955' => "1955",
            '1956' => "1956",
            '1957' => "1957",
            '1958' => "1958",
            '1959' => "1959",
            '1960' => "1960",
            '1961' => "1961",
            '1962' => "1962",
            '1963' => "1963",
            '1964' => "1964",
            '1965' => "1965",
            '1966' => "1966",
            '1967' => "1967",
            '1968' => "1968",
            '1969' => "1969",
            '1970' => "1970",
            '1971' => "1971",
            '1972' => "1972",
            '1973' => "1973",
            '1974' => "1974",
            '1975' => "1975",
            '1976' => "1976",
            '1977' => "1977",
            '1978' => "1978",
            '1979' => "1979",
            '1980' => "1980",
            '1981' => "1981",
            '1982' => "1982",
            '1983' => "1983",
            '1984' => "1984",
            '1985' => "1985",
            '1986' => "1986",
            '1987' => "1987",
            '1988' => "1988",
            '1989' => "1989",
            '1990' => "1990",
            '1991' => "1991",
            '1992' => "1992",
            '1993' => "1993",
            '1994' => "1994",
            '1995' => "1995",
            '1996' => "1996",
            '1997' => "1997",
            '1998' => "1998",
            '1999' => "1999",
            '2000' => "2000",
            '2001' => "2001",
            '2002' => "2002",
            '2003' => "2003",
            '2004' => "2004",
            '2005' => "2005",
            '2006' => "2006",
            '2007' => "2007",
            '2008' => "2008",
            '2009' => "2009",
            '2010' => "2010",
            '2011' => "2011",
            '2012' => "2012",
            '2013' => "2013",
            '2014' => "2014",
            '2015' => "2015",
            '2016' => "2016",
            '2017' => "2017",
            '2018' => "2018",
            '2019' => "2019",
            '2020' => "2020",
            '2021' => "2021",
            '2022' => "2022",
            '2023' => "2023",
            '2024' => "2024",
            '2025' => "2025",
            '2026' => "2026",
            '2027' => "2027",
            '2028' => "2028",
            '2029' => "2029",
            '2030' => "2030"];

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName);
        return view('admin.my_cars.create')->with([
            'categories' => $categories,
            'regional_specs' => $regional_specs,
            'engineType' => $engineType,
            'attributes' => $attributes,
            'features' => $features,
            'transmission_type' => MyCar::$TRANSMISSION_TYPE_TEXT,
            'media_types' => MyCar::$MEDIA_TYPES,
            'carTypes' => $carTypes,
            'carModels' => $carModels,
            'regions' => $regions,
            'years' => $years,
            'brands' => $brands
        ]);
    }

    /**
     * @param CreateMyCarRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateMyCarRequest $request)
    {
        //$request->validate($validationArray, $validationMessages);
        $myCar = $this->myCarRepository->saveRecord($request);

        if ($request->category_id != MyCar::LIMITED_EDITION) {
            if (!empty(array_filter($request->attribute))) {
                foreach ($request->attribute as $key => $item) {
                    $myCar->carAttributes()->attach($key, ['value' => $item]);
                }
            }
        }

        Flash::success('Car saved successfully . ');
        return redirect(route('admin.myCars.index'));
    }

    /**
     * Display the specified MyCar.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $myCar = $this->myCarRepository->findWithoutFail($id);

        if (empty($myCar)) {
            Flash::error('Car not found');

            return redirect(route('admin.myCars.index'));
        }

        $attributes = $this->attributeRepository->all();
        $features = $this->featureRepository->all();
        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $myCar);
        return view('admin.my_cars.show')->with([
            'myCar' => $myCar,
            'attributes' => $attributes,
            'features' => $features
        ]);
    }

    /**
     * Show the form for editing the specified MyCar.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $myCar = $this->myCarRepository->findWithoutFail($id);
        if (empty($myCar)) {
            Flash::error('Car not found');
            return redirect(route('admin.myCars.index'));
        }

        $limited_edition_specs = null;
        if (!empty($myCar->limited_edition_specs)) {
            $limited_edition_specs = json_decode($myCar->limited_edition_specs, true);
        }

        $brands = $this->brandRepository->all()->pluck('name', 'id');
        $categories = $this->categoryRepository->getCarCategories()->pluck('name', 'id');
        $regional_specs = $this->regionalSpecRepository->all()->pluck('name', 'id');
        $engineType = $this->engineTypeRepository->all()->pluck('name', 'id');
        $attributes = $this->attributeRepository->all();
        $features = $this->featureRepository->all();
        $carTypes = $this->carTypeRepository->getRootTypes()->pluck('name', 'id');
        $carModels = $this->modelRepository->all()->pluck('name', 'id');
        $regions = $this->regionRepository->orderBy('created_at', 'ASC')->all()->pluck('name', 'id');
        $years = ['1950' => "1950",
            '1951' => "1951",
            '1952' => "1952",
            '1953' => "1953",
            '1954' => "1954",
            '1955' => "1955",
            '1956' => "1956",
            '1957' => "1957",
            '1958' => "1958",
            '1959' => "1959",
            '1960' => "1960",
            '1961' => "1961",
            '1962' => "1962",
            '1963' => "1963",
            '1964' => "1964",
            '1965' => "1965",
            '1966' => "1966",
            '1967' => "1967",
            '1968' => "1968",
            '1969' => "1969",
            '1970' => "1970",
            '1971' => "1971",
            '1972' => "1972",
            '1973' => "1973",
            '1974' => "1974",
            '1975' => "1975",
            '1976' => "1976",
            '1977' => "1977",
            '1978' => "1978",
            '1979' => "1979",
            '1980' => "1980",
            '1981' => "1981",
            '1982' => "1982",
            '1983' => "1983",
            '1984' => "1984",
            '1985' => "1985",
            '1986' => "1986",
            '1987' => "1987",
            '1988' => "1988",
            '1989' => "1989",
            '1990' => "1990",
            '1991' => "1991",
            '1992' => "1992",
            '1993' => "1993",
            '1994' => "1994",
            '1995' => "1995",
            '1996' => "1996",
            '1997' => "1997",
            '1998' => "1998",
            '1999' => "1999",
            '2000' => "2000",
            '2001' => "2001",
            '2002' => "2002",
            '2003' => "2003",
            '2004' => "2004",
            '2005' => "2005",
            '2006' => "2006",
            '2007' => "2007",
            '2008' => "2008",
            '2009' => "2009",
            '2010' => "2010",
            '2011' => "2011",
            '2012' => "2012",
            '2013' => "2013",
            '2014' => "2014",
            '2015' => "2015",
            '2016' => "2016",
            '2017' => "2017",
            '2018' => "2018",
            '2019' => "2019",
            '2020' => "2020",
            '2021' => "2021",
            '2022' => "2022",
            '2023' => "2023",
            '2024' => "2024",
            '2025' => "2025",
            '2026' => "2026",
            '2027' => "2027",
            '2028' => "2028",
            '2029' => "2029",
            '2030' => "2030"];

        BreadcrumbsRegister::Register($this->ModelName, $this->BreadCrumbName, $myCar);
        return view('admin.my_cars.edit')->with([
            'myCar' => $myCar,
            'categories' => $categories,
            'regional_specs' => $regional_specs,
            'engineType' => $engineType,
            'attributes' => $attributes,
            'features' => $features,
            'transmission_type' => MyCar::$TRANSMISSION_TYPE_TEXT,
            'status' => MyCar::$STATUS,
            'media_types' => MyCar::$MEDIA_TYPES,
            'carTypes' => $carTypes,
            'carModels' => $carModels,
            'brands' => $brands,
            'regions' => $regions,
            'years' => $years,
            'limited_edition_specs' => $limited_edition_specs,
        ]);
    }

    /**
     * Update the specified MyCar in storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $myCar = $this->myCarRepository->findWithoutFail($id);

        if (empty($myCar)) {
            Flash::error('Car not found');
            return redirect(route('admin.myCars.index'));
        }

        if ($myCar->media->count() == 0) {
            $imageValidation = ['media' => 'required'];
        } else {
            $imageValidation = [];
        }

        $request->validate($imageValidation);

        if ($request->category_id == MyCar::LIMITED_EDITION) {
            $validatedData = $request->validate(
                array_merge(array_filter($imageValidation), [
//                'category_id'               => 'required',
//                'model_id'                  => 'required',
//                'year'                      => 'required',
//                'regional_specification_id' => 'required',
//                'email'                     => 'required|email',
                    'amount' => 'required',
                    'name' => 'required',
                    'chassis' => 'required',
                    'is_featured' => 'check_featured_update',
                    'length' => 'required',
                    'width' => 'required',
                    'height' => 'required',
                    'weight_dist' => 'required',
                    'trunk' => 'required',
                    'weight' => 'required',
                    'seats' => 'required',
                    'drive_train' => 'required',
                    'displacement' => 'required',
                    'cylinders' => 'required',
                    'max_speed' => 'required',
                    'acceleration' => 'required',
                    'hp_rpm' => 'required',
                    'torque' => 'required',
                    'gearbox' => 'required',
                    'brakes' => 'required',
                    'suspension' => 'required',
                    'front_tyre' => 'required',
                    'back_tyre' => 'required',
                    'consumption' => 'required',
                    'emission' => 'required',
                    'warranty' => 'required',
                    'maintenance' => 'required',
                    'to' => 'required|greater_than_field:from',
//                    'depreciation_trend' => 'required',
                    'price' => 'required',
                    'price.*' => 'numeric',
                    'media.*' => 'image|mimes:jpg,jpeg,png|max:500'
                ]), [
                /*'category_id.required' => 'The category field is required.',
                'model_id.required'    => 'The model field is required.',
                'year.required'        => 'The year field is required.',*/
                'amount.required' => 'The amount field is required.',
                'price.required' => 'The price must be filled.',
                'price.*' => 'The all price must be filled.',
                'name.required' => 'The name field is required.',
                'media.required' => 'The media is required.',
                'media.*.mimes' => 'The media must be a file of type: jpg, jpeg, png.',
                'media.*' => 'The media may not be greater than 500 kilobytes.'
            ]);
        } elseif ($request->category_id == MyCar::APPROVED_PRE_OWNED || $request->category_id == MyCar::CLASSIC_CARS) {
            $validatedData = $request->validate(array_merge(array_filter($imageValidation), [
//                'category_id'               => 'required',
//                'model_id'                  => 'required',
//                'transmission_type'         => 'required',
//                'engine_type_id'            => 'required',
//                'regional_specification_id' => 'required',
//                'email'                     => 'required|email',
//                'phone'                     => 'phone',
//                'year'        => 'required',
                'chassis' => 'required',
                'amount' => 'required',
                'average_mkp' => 'required',
                'kilometer' => 'required',
                'name' => 'required',
                'is_featured' => 'check_featured_update',
                'media.*' => 'image|mimes:jpg,jpeg,png|max:500',
                'attribute.1' => 'attr',
                'attribute.2' => 'attr',
                'attribute.3' => 'attr',
                'attribute.4' => 'attr',
                'attribute.5' => 'attr',
                'attribute.6' => 'attr'
            ]), [
//                'category_id.required'       => 'The category field is required.',
//                'model_id.required'          => 'The model field is required.',
//                'transmission_type.required' => 'The transmission field is required.',
//                'engine_type_id.required'    => 'The engine field is required.',
//                'email.required'             => 'The amount field is required.',
//                'year.required'        => 'The year field is required.',
                'chassis.required' => 'The chassis field is required.',
                'amount.required' => 'The Amount field is required.',
                'average_mkp.required' => 'The average MKP field is required.',
                'kilometer.required' => 'The mileage field is required.',
                'name.required' => 'The car name field is required.',
                'media.required' => 'The media is required.',
                'media.*.mimes' => 'The media must be a file of type: jpg, jpeg, png.',
                'media.*' => 'The media may not be greater than 500 kilobytes.',
            ]);
        } else {
            $validatedData = $request->validate(array_merge(array_filter($imageValidation), [
//                'category_id'               => 'required',
//                'model_id'                  => 'required',
//                'transmission_type'         => 'required',
//                'engine_type_id'            => 'required',
//                'regional_specification_id' => 'required',
//                'email'                     => 'required|email',
                'year' => 'required',
                'amount' => 'required',
                'phone' => 'phone',
                'is_featured' => 'check_featured_update',
                'media.*' => 'image|mimes:jpg,jpeg,png|max:500',
                'attribute.1' => 'attr',
                'attribute.2' => 'attr',
                'attribute.3' => 'attr',
                'attribute.4' => 'attr',
                'attribute.5' => 'attr',
                'attribute.6' => 'attr'
            ]), [
//                'category_id.required'       => 'The category field is required.',
//                'model_id.required'          => 'The model field is required.',
//                'transmission_type.required' => 'The transmission field is required.',
//                'engine_type_id.required'    => 'The engine field is required.',
//                'email.required'             => 'The email field is required.',
                'year.required' => 'The year field is required.',
                'amount.required' => 'The amount field is required.',
                'media.required' => 'The media is required.',
                'media.*.mimes' => 'The media must be a file of type: jpg, jpeg, png.',
                'media.*' => 'The media may not be greater than 500 kilobytes.',
            ]);
        }

        /*if ($request->category_id == MyCar::LIMITED_EDITION) {
            $validatedData = $request->validate(array_merge(array_filter($imageValidation), [
//                'category_id'               => 'sometimes | nullable | required',
//                'model_id'                  => 'sometimes | nullable | required',
//                'year'                      => 'sometimes | nullable | required',
//                'regional_specification_id' => 'sometimes | nullable | required',
//                'email'                     => 'sometimes | nullable | required | email',
                'amount'             => 'required',
                'chassis'            => 'required',
                'length'             => 'required',
                'width'              => 'required',
                'height'             => 'required',
                'weight_dist'        => 'required',
                'trunk'              => 'required',
                'weight'             => 'required',
                'seats'              => 'required',
                'drive_train'        => 'required',
                'displacement'       => 'required',
                'cylinders'          => 'required',
                'max_speed'          => 'required',
                'acceleration'       => 'required',
                'hp_rpm'             => 'required',
                'torque'             => 'required',
                'gearbox'            => 'required',
                'brakes'             => 'required',
                'suspension'         => 'required',
                'front_tyre'         => 'required',
                'back_tyre'          => 'required',
                'consumption'        => 'required',
                'emission'           => 'required',
                'warranty'           => 'required',
                'maintenance'        => 'required',
                'to'                 => 'required|greater_than_field:from',
                'depreciation_trend' => 'required',
                'price .*'           => 'required',
                'media.*'            => 'image|mimes:jpg,jpeg,png|max:500'
            ]), [
//                'category_id . required' => 'The category field is required . ',
//                'model_id . required'    => 'The model field is required . ',
//                'year . required'        => 'The year field is required . ',
//                'email . required'       => 'The amount field is required . '
                'amount.required' => 'The amount field is required . ',
                'media.required'  => 'The media is required.',
                'media.*.mimes'   => 'The media must be a file of type: jpg, jpeg, png.',
                'media.*'         => 'The media may not be greater than 500 kilobytes.',
                'price.*'         => 'The all price must be filled . ',
            ]);
        } elseif ($request->category_id == MyCar::APPROVED_PRE_OWNED || $request->category_id == MyCar::CLASSIC_CARS) {
            if ($myCar->media->count() == 0) {
                $imageValidation = [];
                $imageValidation = array_merge([
                    'media' => 'required'
                ], [
                    'category_id'               => 'required',
                    'model_id'                  => 'required',
                    'year'                      => 'required',
                    'transmission_type'         => 'required',
                    'engine_type_id'            => 'required',
                    'amount'                    => 'required',
                    'regional_specification_id' => 'required',
                    'kilometer'                 => 'required',
                    'average_mkp'               => 'required',
                    'chassis'                   => 'required',
                    'name'                      => 'required',
                    'email'                     => 'required | email',
                    'phone'                     => 'phone',
                    'media .*'                  => 'image | mimes:jpg,jpeg,png | max = 500',
                    'attribute .*'              => 'attr'
                ]);
            } else {
                $imageValidation = [];
                $imageValidation = [
                    'category_id'               => 'required',
                    'model_id'                  => 'required',
                    'year'                      => 'required',
                    'transmission_type'         => 'required',
                    'engine_type_id'            => 'required',
                    'amount'                    => 'required',
                    'regional_specification_id' => 'required',
                    'kilometer'                 => 'required',
                    'average_mkp'               => 'required',
                    'chassis'                   => 'required',
                    'name'                      => 'required',
//                    'email'                     => 'required | email',
                    'phone'                     => 'phone',
                    'media .*'                  => 'image | mimes:jpg,jpeg,png | max = 500',
                    'attribute .*'              => 'attr'
                ];
            }
            $validatedData = $request->validate($imageValidation, [
                'category_id . required'       => 'The category field is required . ',
                'model_id . required'          => 'The model field is required . ',
                'year . required'              => 'The year field is required . ',
                'transmission_type . required' => 'The transmission field is required . ',
                'engine_type_id . required'    => 'The engine field is required . ',
                'amount . required'            => 'The amount field is required . ',
                'media . required'             => 'The media is required . ',
                'media .*'                     => 'The media must be a file of type: jpg, jpeg, png . ',
                'kilometer . required'         => 'The Mileage field is required . ',
                'average_mkp . required'       => 'The Average MKP field is required . ',
//                'email . required'             => 'The amount field is required . '
            ]);
        } else {
            if ($myCar->media->count() == 0) {
                $imageValidation = [];
                $imageValidation = array_merge([
                    'media' => 'required'
                ], [
                    'category_id'               => 'sometimes | nullable | required',
                    'model_id'                  => 'sometimes | nullable | required',
                    'year'                      => 'sometimes | nullable | required',
                    'transmission_type'         => 'sometimes | nullable | required',
                    'engine_type_id'            => 'sometimes | nullable | required',
                    'amount'                    => 'sometimes | nullable | required',
                    'regional_specification_id' => 'sometimes | nullable | required',
                    'email'                     => 'sometimes | nullable | required | email',
                    'phone'                     => 'sometimes | nullable | phone',
                    'media .*'                  => 'image | mimes:jpg,jpeg,png | max = 500',
                    'attribute .*'              => 'attr'
                ]);
            } else {
                $imageValidation = [];
                $imageValidation = [
                    'category_id'               => 'sometimes | nullable | required',
                    'model_id'                  => 'sometimes | nullable | required',
                    'year'                      => 'sometimes | nullable | required',
                    'transmission_type'         => 'sometimes | nullable | required',
                    'engine_type_id'            => 'sometimes | nullable | required',
                    'amount'                    => 'sometimes | nullable | required',
                    'regional_specification_id' => 'sometimes | nullable | required',
                    'email'                     => 'sometimes | nullable | required | email',
                    'phone'                     => 'sometimes | nullable | phone',
                    'media .*'                  => 'image | mimes:jpg,jpeg,png | max = 500',
                    'attribute .*'              => 'attr'
                ];
            }
            $validatedData = $request->validate($imageValidation, [
                'category_id . required'       => 'The category field is required . ',
                'model_id . required'          => 'The model field is required . ',
                'year . required'              => 'The year field is required . ',
                'transmission_type . required' => 'The transmission field is required . ',
                'engine_type_id . required'    => 'The engine field is required . ',
                'amount . required'            => 'The amount field is required . ',
                'media . required'             => 'The media is required . ',
                'media .*'                     => 'The media must be a file of type: jpg, jpeg, png . ',
                'email . required'             => 'The amount field is required . '
            ]);
        }*/


        if ($request->category_id != $myCar->category_id) {
            CarRegion::where('car_id', $id)->delete();
        }
        $myCar = $this->myCarRepository->updateRecord($request, $myCar);

        if ($request->category_id != MyCar::LIMITED_EDITION) {

            if (!empty(array_filter($request->attribute))) {
                $carAttributes = [];
                foreach ($request->attribute as $key => $item) {
                    if ($item) {
                        $carAttributes[$key] = ['value' => $item];
                    }
                }
                $myCar->carAttributes()->sync($carAttributes, false);
            }

            /*if (!empty(array_filter($request->feature))) {
                $carFeatures = [];
                foreach ($request->feature as $key => $item) {
                    if (!empty($item)) {
                        $carFeatures[] = $key;
                    }
                }

                $myCar->myCarFeatures()->delete();
                $myCar->carFeatures()->sync($carFeatures, false);
            }*/
        }

        Flash::success('Car updated successfully . ');
        return redirect(route('admin.myCars.index'));
    }

    /**
     * Remove the specified MyCar from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $myCar = $this->myCarRepository->findWithoutFail($id);
        if (empty($myCar)) {
            Flash::error('Car not found');
            return redirect(route('admin.myCars.index'));
        }

        if (TradeInCar::where('owner_car_id', $id)->orWhere('customer_car_id', $id)->count() > 0) {
            Flash::error('Car cannot be deleted, Trade request found');
            return redirect(route('admin.myCars.index'));
        }
        $this->myCarRepository->delete($id);

        Flash::success('Car deleted successfully . ');
        return redirect(route('admin.myCars.index'));
    }
}