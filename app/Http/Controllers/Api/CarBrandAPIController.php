<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateCarBrandAPIRequest;
use App\Http\Requests\Api\UpdateCarBrandAPIRequest;
use App\Models\CarBrand;
use App\Repositories\Admin\CarBrandRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class CarBrandController
 * @package App\Http\Controllers\Api
 */
class CarBrandAPIController extends AppBaseController
{
    /** @var  CarBrandRepository */
    private $carBrandRepository;

    public function __construct(CarBrandRepository $carBrandRepo)
    {
        $this->carBrandRepository = $carBrandRepo;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/carBrands",
     *      summary="Get a listing of the CarBrands.",
     *      tags={"CarBrand"},
     *      description="Get all CarBrands",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="locale",
     *          description="Change the locale.",
     *          default="en",
     *          type="string",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="limit",
     *          description="Change the Default Record Count. If not found, Returns All Records in DB.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="offset",
     *          description="Change the Default Offset of the Query. If not found, 0 will be used.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/CarBrand")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        App::setLocale($request->get('locale', 'en'));
        $this->carBrandRepository->pushCriteria(new RequestCriteria($request));
        $this->carBrandRepository->pushCriteria(new LimitOffsetCriteria($request));

        $carBrands = CarBrand::select('brands.*', 't.name')
            ->join('brand_translations as t', function ($q) {
                return $q->on('t.brand_id', '=', 'brands.id')->where('t.locale', App::getLocale('en'));
            })->orderBy('t.name', 'asc')->get();
        //$carBrands = $this->carBrandRepository->with('translations')->orderBy('translations.name', 'ASC')->get();

        return $this->sendResponse($carBrands->toArray(), 'Car Brands retrieved successfully');
    }

    /**
     * @param CreateCarBrandAPIRequest $request
     * @return Response
     *
     * //@SWG\Post(
     *      path="/carBrands",
     *      summary="Store a newly created CarBrand in storage",
     *      tags={"CarBrand"},
     *      description="Store CarBrand",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CarBrand that should be stored",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/CarBrand")
     *      ),
     *      //@SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          //@SWG\Schema(
     *              type="object",
     *              //@SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              //@SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/CarBrand"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCarBrandAPIRequest $request)
    {
        $input = $request->all();

        $carBrands = $this->carBrandRepository->create($input);

        return $this->sendResponse($carBrands->toArray(), 'Car Brand saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Get(
     *      path="/carBrands/{id}",
     *      summary="Display the specified CarBrand",
     *      tags={"CarBrand"},
     *      description="Get CarBrand",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of CarBrand",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          //@SWG\Schema(
     *              type="object",
     *              //@SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              //@SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/CarBrand"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var CarBrand $carBrand */
        $carBrand = $this->carBrandRepository->findWithoutFail($id);

        if (empty($carBrand)) {
            return $this->sendError('Car Brand not found');
        }

        return $this->sendResponse($carBrand->toArray(), 'Car Brand retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCarBrandAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/carBrands/{id}",
     *      summary="Update the specified CarBrand in storage",
     *      tags={"CarBrand"},
     *      description="Update CarBrand",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of CarBrand",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CarBrand that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/CarBrand")
     *      ),
     *      //@SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          //@SWG\Schema(
     *              type="object",
     *              //@SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              //@SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/CarBrand"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCarBrandAPIRequest $request)
    {
        $input = $request->all();

        /** @var CarBrand $carBrand */
        $carBrand = $this->carBrandRepository->findWithoutFail($id);

        if (empty($carBrand)) {
            return $this->sendError('Car Brand not found');
        }

        $carBrand = $this->carBrandRepository->update($input, $id);

        return $this->sendResponse($carBrand->toArray(), 'CarBrand updated successfully');
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     *
     * //@SWG\Delete(
     *      path="/carBrands/{id}",
     *      summary="Remove the specified CarBrand from storage",
     *      tags={"CarBrand"},
     *      description="Delete CarBrand",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of CarBrand",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          //@SWG\Schema(
     *              type="object",
     *              //@SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              //@SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var CarBrand $carBrand */
        $carBrand = $this->carBrandRepository->findWithoutFail($id);

        if (empty($carBrand)) {
            return $this->sendError('Car Brand not found');
        }

        $carBrand->delete();

        return $this->sendResponse($id, 'Car Brand deleted successfully');
    }
}