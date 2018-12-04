<?php

namespace App\Http\Controllers\Api;

use App\Criteria\CarModelFilterCriteria;
use App\Http\Requests\Api\CreateCarModelAPIRequest;
use App\Http\Requests\Api\UpdateCarModelAPIRequest;
use App\Models\CarModel;
use App\Repositories\Admin\CarModelRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class CarModelController
 * @package App\Http\Controllers\Api
 */
class CarModelAPIController extends AppBaseController
{
    /** @var  CarModelRepository */
    private $carModelRepository;

    public function __construct(CarModelRepository $carModelRepo)
    {
        $this->carModelRepository = $carModelRepo;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/carModels",
     *      summary="Get a listing of the CarModels.",
     *      tags={"CarModel"},
     *      description="Get all CarModels",
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
     *      @SWG\Parameter(
     *          name="brand_id",
     *          description="Get brand's models.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="name",
     *          description="Search Car model by name.",
     *          type="string",
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
     *                  @SWG\Items(ref="#/definitions/CarModel")
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
        \App::setLocale($request->get('locale', 'en'));
        $this->carModelRepository->pushCriteria(new RequestCriteria($request));
        $this->carModelRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->carModelRepository->pushCriteria(new CarModelFilterCriteria($request));
        $carModels = $this->carModelRepository->all();

        return $this->sendResponse($carModels->toArray(), 'Car Models retrieved successfully');
    }

    /**
     * @param CreateCarModelAPIRequest $request
     * @return Response
     *
     * //@SWG\Post(
     *      path="/carModels",
     *      summary="Store a newly created CarModel in storage",
     *      tags={"CarModel"},
     *      description="Store CarModel",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CarModel that should be stored",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/CarModel")
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
     *                  ref="#/definitions/CarModel"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCarModelAPIRequest $request)
    {
        $input = $request->all();

        $carModels = $this->carModelRepository->create($input);

        return $this->sendResponse($carModels->toArray(), 'Car Model saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Get(
     *      path="/carModels/{id}",
     *      summary="Display the specified CarModel",
     *      tags={"CarModel"},
     *      description="Get CarModel",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of CarModel",
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
     *                  ref="#/definitions/CarModel"
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
        /** @var CarModel $carModel */
        $carModel = $this->carModelRepository->findWithoutFail($id);

        if (empty($carModel)) {
            return $this->sendError('Car Model not found');
        }

        return $this->sendResponse($carModel->toArray(), 'Car Model retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCarModelAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/carModels/{id}",
     *      summary="Update the specified CarModel in storage",
     *      tags={"CarModel"},
     *      description="Update CarModel",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of CarModel",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CarModel that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/CarModel")
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
     *                  ref="#/definitions/CarModel"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCarModelAPIRequest $request)
    {
        $input = $request->all();

        /** @var CarModel $carModel */
        $carModel = $this->carModelRepository->findWithoutFail($id);

        if (empty($carModel)) {
            return $this->sendError('Car Model not found');
        }

        $carModel = $this->carModelRepository->update($input, $id);

        return $this->sendResponse($carModel->toArray(), 'CarModel updated successfully');
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     *
     * //@SWG\Delete(
     *      path="/carModels/{id}",
     *      summary="Remove the specified CarModel from storage",
     *      tags={"CarModel"},
     *      description="Delete CarModel",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of CarModel",
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
        /** @var CarModel $carModel */
        $carModel = $this->carModelRepository->findWithoutFail($id);

        if (empty($carModel)) {
            return $this->sendError('Car Model not found');
        }

        $carModel->delete();

        return $this->sendResponse($id, 'Car Model deleted successfully');
    }
}
