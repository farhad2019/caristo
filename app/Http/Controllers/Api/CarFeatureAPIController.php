<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateCarFeatureAPIRequest;
use App\Http\Requests\Api\UpdateCarFeatureAPIRequest;
use App\Models\CarFeature;
use App\Repositories\Admin\CarFeatureRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class CarFeatureController
 * @package App\Http\Controllers\Api
 */
class CarFeatureAPIController extends AppBaseController
{
    /** @var  CarFeatureRepository */
    private $carFeatureRepository;

    public function __construct(CarFeatureRepository $carFeatureRepo)
    {
        $this->carFeatureRepository = $carFeatureRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/carFeatures",
     *      summary="Get a listing of the CarFeatures.",
     *      tags={"CarFeature"},
     *      description="Get all CarFeatures",
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
     *                  @SWG\Items(ref="#/definitions/CarFeature")
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
        $this->carFeatureRepository->pushCriteria(new RequestCriteria($request));
        $this->carFeatureRepository->pushCriteria(new LimitOffsetCriteria($request));
        $carFeatures = $this->carFeatureRepository->all();

        return $this->sendResponse($carFeatures->toArray(), 'Car Features retrieved successfully');
    }

    /**
     * @param CreateCarFeatureAPIRequest $request
     * @return Response
     *
     * //@SWG\Post(
     *      path="/carFeatures",
     *      summary="Store a newly created CarFeature in storage",
     *      tags={"CarFeature"},
     *      description="Store CarFeature",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CarFeature that should be stored",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/CarFeature")
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
     *                  ref="#/definitions/CarFeature"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCarFeatureAPIRequest $request)
    {
        $input = $request->all();

        $carFeatures = $this->carFeatureRepository->create($input);

        return $this->sendResponse($carFeatures->toArray(), 'Car Feature saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Get(
     *      path="/carFeatures/{id}",
     *      summary="Display the specified CarFeature",
     *      tags={"CarFeature"},
     *      description="Get CarFeature",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of CarFeature",
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
     *                  ref="#/definitions/CarFeature"
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
        /** @var CarFeature $carFeature */
        $carFeature = $this->carFeatureRepository->findWithoutFail($id);

        if (empty($carFeature)) {
            return $this->sendError('Car Feature not found');
        }

        return $this->sendResponse($carFeature->toArray(), 'Car Feature retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCarFeatureAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/carFeatures/{id}",
     *      summary="Update the specified CarFeature in storage",
     *      tags={"CarFeature"},
     *      description="Update CarFeature",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of CarFeature",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CarFeature that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/CarFeature")
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
     *                  ref="#/definitions/CarFeature"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCarFeatureAPIRequest $request)
    {
        $input = $request->all();

        /** @var CarFeature $carFeature */
        $carFeature = $this->carFeatureRepository->findWithoutFail($id);

        if (empty($carFeature)) {
            return $this->sendError('Car Feature not found');
        }

        $carFeature = $this->carFeatureRepository->update($input, $id);

        return $this->sendResponse($carFeature->toArray(), 'CarFeature updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Delete(
     *      path="/carFeatures/{id}",
     *      summary="Remove the specified CarFeature from storage",
     *      tags={"CarFeature"},
     *      description="Delete CarFeature",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of CarFeature",
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
        /** @var CarFeature $carFeature */
        $carFeature = $this->carFeatureRepository->findWithoutFail($id);

        if (empty($carFeature)) {
            return $this->sendError('Car Feature not found');
        }

        $carFeature->delete();

        return $this->sendResponse($id, 'Car Feature deleted successfully');
    }
}
