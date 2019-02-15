<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateWalkThroughAPIRequest;
use App\Http\Requests\Api\UpdateWalkThroughAPIRequest;
use App\Models\WalkThrough;
use App\Repositories\Admin\WalkThroughRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class WalkThroughController
 * @package App\Http\Controllers\Api
 */
class WalkThroughAPIController extends AppBaseController
{
    /** @var  WalkThroughRepository */
    private $walkThroughRepository;

    public function __construct(WalkThroughRepository $walkThroughRepo)
    {
        $this->walkThroughRepository = $walkThroughRepo;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/walkThroughs",
     *      summary="Get a listing of the WalkThroughs.",
     *      tags={"WalkThrough"},
     *      description="Get all WalkThroughs",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=false,
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
     *                  @SWG\Items(ref="#/definitions/WalkThrough")
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
        $this->walkThroughRepository->pushCriteria(new RequestCriteria($request));
        $this->walkThroughRepository->pushCriteria(new LimitOffsetCriteria($request));
        $walkThroughs = $this->walkThroughRepository->all();

        return $this->sendResponse($walkThroughs->toArray(), 'Walk Through retrieved successfully');
    }

    /**
     * @param CreateWalkThroughAPIRequest $request
     * @return Response
     *
     * //@SWG\Post(
     *      path="/walkThroughs",
     *      summary="Store a newly created WalkThrough in storage",
     *      tags={"WalkThrough"},
     *      description="Store WalkThrough",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="WalkThrough that should be stored",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/WalkThrough")
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
     *                  ref="#/definitions/WalkThrough"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateWalkThroughAPIRequest $request)
    {
        $input = $request->all();

        $walkThroughs = $this->walkThroughRepository->create($input);

        return $this->sendResponse($walkThroughs->toArray(), 'Walk Through saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/walkThroughs/{id}",
     *      summary="Display the specified WalkThrough",
     *      tags={"WalkThrough"},
     *      description="Get WalkThrough",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=false,
     *          default="Bearer ABC123",
     *          in="header"
     *      ),
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of WalkThrough",
     *          type="integer",
     *          required=true,
     *          in="path"
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
     *                  ref="#/definitions/WalkThrough"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var WalkThrough $walkThrough */
        $walkThrough = $this->walkThroughRepository->findWithoutFail($id);

        if (empty($walkThrough)) {
            return $this->sendError('Walk Through not found');
        }

        return $this->sendResponse($walkThrough->toArray(), 'Walk Through retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateWalkThroughAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/walkThroughs/{id}",
     *      summary="Update the specified WalkThrough in storage",
     *      tags={"WalkThrough"},
     *      description="Update WalkThrough",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of WalkThrough",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="WalkThrough that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/WalkThrough")
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
     *                  ref="#/definitions/WalkThrough"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdateWalkThroughAPIRequest $request)
    {
        $input = $request->all();

        /** @var WalkThrough $walkThrough */
        $walkThrough = $this->walkThroughRepository->findWithoutFail($id);

        if (empty($walkThrough)) {
            return $this->sendError('Walk Through not found');
        }

        $walkThrough = $this->walkThroughRepository->update($input, $id);

        return $this->sendResponse($walkThrough->toArray(), 'WalkThrough updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Delete(
     *      path="/walkThroughs/{id}",
     *      summary="Remove the specified WalkThrough from storage",
     *      tags={"WalkThrough"},
     *      description="Delete WalkThrough",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of WalkThrough",
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
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var WalkThrough $walkThrough */
        $walkThrough = $this->walkThroughRepository->findWithoutFail($id);

        if (empty($walkThrough)) {
            return $this->sendError('Walk Through not found');
        }

        $walkThrough->delete();

        return $this->sendResponse($id, 'Walk Through deleted successfully');
    }
}
