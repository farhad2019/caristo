<?php

namespace App\Http\Controllers\Api;

use App\Criteria\CarTypeCriteria;
use App\Http\Requests\Api\CreateCarTypeAPIRequest;
use App\Http\Requests\Api\UpdateCarTypeAPIRequest;
use App\Models\CarType;
use App\Repositories\Admin\CarTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class CarTypeController
 * @package App\Http\Controllers\Api
 */
class CarTypeAPIController extends AppBaseController
{
    /** @var  CarTypeRepository */
    private $carTypeRepository;

    public function __construct(CarTypeRepository $carTypeRepo)
    {
        $this->carTypeRepository = $carTypeRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/carTypes",
     *      summary="Get a listing of the CarTypes.",
     *      tags={"CarType"},
     *      description="Get all CarTypes",
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
     *          name="parent_id",
     *          description="parent id",
     *          type="integer",
     *          required=false,
     *          default=0,
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
     *                  @SWG\Items(ref="#/definitions/CarType")
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
        $this->carTypeRepository->pushCriteria(new RequestCriteria($request));
        $this->carTypeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->carTypeRepository->pushCriteria(new CarTypeCriteria($request));
        $carTypes = $this->carTypeRepository->all();

        return $this->sendResponse($carTypes->toArray(), 'Segments retrieved successfully');
    }

    /**
     * @param CreateCarTypeAPIRequest $request
     * @return Response
     *
     * //@SWG\Post(
     *      path="/carTypes",
     *      summary="Store a newly created CarType in storage",
     *      tags={"CarType"},
     *      description="Store CarType",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CarType that should be stored",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/CarType")
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
     *                  ref="#/definitions/CarType"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCarTypeAPIRequest $request)
    {
        $input = $request->all();

        $carTypes = $this->carTypeRepository->create($input);

        return $this->sendResponse($carTypes->toArray(), 'Segments saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Get(
     *      path="/carTypes/{id}",
     *      summary="Display the specified CarType",
     *      tags={"CarType"},
     *      description="Get CarType",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of CarType",
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
     *                  ref="#/definitions/CarType"
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
        /** @var CarType $carType */
        $carType = $this->carTypeRepository->findWithoutFail($id);

        if (empty($carType)) {
            return $this->sendError('Segments not found');
        }

        return $this->sendResponse($carType->toArray(), 'Segments retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCarTypeAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/carTypes/{id}",
     *      summary="Update the specified CarType in storage",
     *      tags={"CarType"},
     *      description="Update CarType",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of CarType",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CarType that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/CarType")
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
     *                  ref="#/definitions/CarType"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCarTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var CarType $carType */
        $carType = $this->carTypeRepository->findWithoutFail($id);

        if (empty($carType)) {
            return $this->sendError('Segments not found');
        }

        $carType = $this->carTypeRepository->update($input, $id);

        return $this->sendResponse($carType->toArray(), 'CarType updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * //@SWG\Delete(
     *      path="/carTypes/{id}",
     *      summary="Remove the specified CarType from storage",
     *      tags={"CarType"},
     *      description="Delete CarType",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of CarType",
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
        /** @var CarType $carType */
        $carType = $this->carTypeRepository->findWithoutFail($id);

        if (empty($carType)) {
            return $this->sendError('Segments not found');
        }

        $carType->delete();

        return $this->sendResponse($id, 'Segments deleted successfully');
    }
}
