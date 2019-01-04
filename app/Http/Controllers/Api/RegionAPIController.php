<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateRegionAPIRequest;
use App\Http\Requests\Api\UpdateRegionAPIRequest;
use App\Models\Region;
use App\Repositories\Admin\RegionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class RegionController
 * @package App\Http\Controllers\Api
 */
class RegionAPIController extends AppBaseController
{
    /** @var  RegionRepository */
    private $regionRepository;

    public function __construct(RegionRepository $regionRepo)
    {
        $this->regionRepository = $regionRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/regions",
     *      summary="Get a listing of the Regions.",
     *      tags={"Region"},
     *      description="Get all Regions",
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
     *                  @SWG\Items(ref="#/definitions/Region")
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
        $this->regionRepository->pushCriteria(new RequestCriteria($request));
        $this->regionRepository->pushCriteria(new LimitOffsetCriteria($request));
        $regions = $this->regionRepository->orderBy('created_at', 'ASC')->all();

        return $this->sendResponse($regions->toArray(), 'Regions retrieved successfully');
    }

    /**
     * @param CreateRegionAPIRequest $request
     * @return Response
     *
     * //@SWG\Post(
     *      path="/regions",
     *      summary="Store a newly created Region in storage",
     *      tags={"Region"},
     *      description="Store Region",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Region that should be stored",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/Region")
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
     *                  ref="#/definitions/Region"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateRegionAPIRequest $request)
    {
        $input = $request->all();

        $regions = $this->regionRepository->create($input);

        return $this->sendResponse($regions->toArray(), 'Region saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Get(
     *      path="/regions/{id}",
     *      summary="Display the specified Region",
     *      tags={"Region"},
     *      description="Get Region",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of Region",
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
     *                  ref="#/definitions/Region"
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
        /** @var Region $region */
        $region = $this->regionRepository->findWithoutFail($id);

        if (empty($region)) {
            return $this->sendError('Region not found');
        }

        return $this->sendResponse($region->toArray(), 'Region retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateRegionAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/regions/{id}",
     *      summary="Update the specified Region in storage",
     *      tags={"Region"},
     *      description="Update Region",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of Region",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Region that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/Region")
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
     *                  ref="#/definitions/Region"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateRegionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Region $region */
        $region = $this->regionRepository->findWithoutFail($id);

        if (empty($region)) {
            return $this->sendError('Region not found');
        }

        $region = $this->regionRepository->update($input, $id);

        return $this->sendResponse($region->toArray(), 'Region updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * //@SWG\Delete(
     *      path="/regions/{id}",
     *      summary="Remove the specified Region from storage",
     *      tags={"Region"},
     *      description="Delete Region",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of Region",
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
        /** @var Region $region */
        $region = $this->regionRepository->findWithoutFail($id);

        if (empty($region)) {
            return $this->sendError('Region not found');
        }

        $region->delete();

        return $this->sendResponse($id, 'Region deleted successfully');
    }
}
