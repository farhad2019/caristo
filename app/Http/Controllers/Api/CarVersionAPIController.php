<?php

namespace App\Http\Controllers\Api;

use App\Criteria\VersionCriteria;
use App\Http\Requests\Api\CreateCarVersionAPIRequest;
use App\Http\Requests\Api\UpdateCarVersionAPIRequest;
use App\Models\CarVersion;
use App\Repositories\Admin\CarVersionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class CarVersionController
 * @package App\Http\Controllers\Api
 */

class CarVersionAPIController extends AppBaseController
{
    /** @var  CarVersionRepository */
    private $carVersionRepository;

    public function __construct(CarVersionRepository $carVersionRepo)
    {
        $this->carVersionRepository = $carVersionRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/carVersions",
     *      summary="Get a listing of the CarVersions.",
     *      tags={"CarVersion"},
     *      description="Get all CarVersions",
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
     *          name="model_id",
     *          description="Model Id.",
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
     *                  @SWG\Items(ref="#/definitions/CarVersion")
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
        $this->carVersionRepository->pushCriteria(new RequestCriteria($request));
        $this->carVersionRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->carVersionRepository->pushCriteria(new VersionCriteria($request));
        $carVersions = $this->carVersionRepository->all();

        return $this->sendResponse($carVersions->toArray(), 'Car Versions retrieved successfully');
    }

    /**
     * @param CreateCarVersionAPIRequest $request
     * @return Response
     *
     * //@SWG\Post(
     *      path="/carVersions",
     *      summary="Store a newly created CarVersion in storage",
     *      tags={"CarVersion"},
     *      description="Store CarVersion",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CarVersion that should be stored",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/CarVersion")
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
     *                  ref="#/definitions/CarVersion"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCarVersionAPIRequest $request)
    {
        $input = $request->all();

        $carVersions = $this->carVersionRepository->create($input);

        return $this->sendResponse($carVersions->toArray(), 'Car Version saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Get(
     *      path="/carVersions/{id}",
     *      summary="Display the specified CarVersion",
     *      tags={"CarVersion"},
     *      description="Get CarVersion",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of CarVersion",
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
     *                  ref="#/definitions/CarVersion"
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
        /** @var CarVersion $carVersion */
        $carVersion = $this->carVersionRepository->findWithoutFail($id);

        if (empty($carVersion)) {
            return $this->sendError('Car Version not found');
        }

        return $this->sendResponse($carVersion->toArray(), 'Car Version retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCarVersionAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/carVersions/{id}",
     *      summary="Update the specified CarVersion in storage",
     *      tags={"CarVersion"},
     *      description="Update CarVersion",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of CarVersion",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CarVersion that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/CarVersion")
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
     *                  ref="#/definitions/CarVersion"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCarVersionAPIRequest $request)
    {
        $input = $request->all();

        /** @var CarVersion $carVersion */
        $carVersion = $this->carVersionRepository->findWithoutFail($id);

        if (empty($carVersion)) {
            return $this->sendError('Car Version not found');
        }

        $carVersion = $this->carVersionRepository->update($input, $id);

        return $this->sendResponse($carVersion->toArray(), 'CarVersion updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * //@SWG\Delete(
     *      path="/carVersions/{id}",
     *      summary="Remove the specified CarVersion from storage",
     *      tags={"CarVersion"},
     *      description="Delete CarVersion",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of CarVersion",
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
        /** @var CarVersion $carVersion */
        $carVersion = $this->carVersionRepository->findWithoutFail($id);

        if (empty($carVersion)) {
            return $this->sendError('Car Version not found');
        }

        $carVersion->delete();

        return $this->sendResponse($id, 'Car Version deleted successfully');
    }
}
