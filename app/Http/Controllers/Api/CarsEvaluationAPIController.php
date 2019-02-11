<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateCarsEvaluationAPIRequest;
use App\Http\Requests\Api\UpdateCarsEvaluationAPIRequest;
use App\Models\CarsEvaluation;
use App\Repositories\Admin\CarsEvaluationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class CarsEvaluationController
 * @package App\Http\Controllers\Api
 */
class CarsEvaluationAPIController extends AppBaseController
{
    /** @var  CarsEvaluationRepository */
    private $carsEvaluationRepository;

    public function __construct(CarsEvaluationRepository $carsEvaluationRepo)
    {
        $this->carsEvaluationRepository = $carsEvaluationRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * //@SWG\Get(
     *      path="/carsEvaluations",
     *      summary="Get a listing of the CarsEvaluations.",
     *      tags={"CarsEvaluation"},
     *      description="Get all CarsEvaluations",
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
     *          name="limit",
     *          description="Change the Default Record Count. If not found, Returns All Records in DB.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      //@SWG\Parameter(
     *          name="offset",
     *          description="Change the Default Offset of the Query. If not found, 0 will be used.",
     *          type="integer",
     *          required=false,
     *          in="query"
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
     *                  type="array",
     *                  //@SWG\Items(ref="#/definitions/CarsEvaluation")
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->carsEvaluationRepository->pushCriteria(new RequestCriteria($request));
        $this->carsEvaluationRepository->pushCriteria(new LimitOffsetCriteria($request));
        $carsEvaluations = $this->carsEvaluationRepository->all();

        return $this->sendResponse($carsEvaluations->toArray(), 'Cars Evaluations retrieved successfully');
    }

    /**
     * @param CreateCarsEvaluationAPIRequest $request
     * @return Response
     *
     * //@SWG\Post(
     *      path="/carsEvaluations",
     *      summary="Store a newly created CarsEvaluation in storage",
     *      tags={"CarsEvaluation"},
     *      description="Store CarsEvaluation",
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
     *          description="CarsEvaluation that should be stored",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/CarsEvaluation")
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
     *                  ref="#/definitions/CarsEvaluation"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCarsEvaluationAPIRequest $request)
    {
        $evaluateCarRequest = $this->carsEvaluationRepository->findWhere(['car_id' => $request->car_id]);
        if ($evaluateCarRequest->count() > 0) {
            return $this->sendResponse([], 'This car has already been requested for evaluation!');
        }

        $carsEvaluations = $this->carsEvaluationRepository->saveRecord($request);
        return $this->sendResponse($carsEvaluations->toArray(), 'Cars Evaluation saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Get(
     *      path="/carsEvaluations/{id}",
     *      summary="Display the specified CarsEvaluation",
     *      tags={"CarsEvaluation"},
     *      description="Get CarsEvaluation",
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
     *          description="id of CarsEvaluation",
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
     *                  ref="#/definitions/CarsEvaluation"
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
        /** @var CarsEvaluation $carsEvaluation */
        $carsEvaluation = $this->carsEvaluationRepository->findWithoutFail($id);

        if (empty($carsEvaluation)) {
            return $this->sendError('Cars Evaluation not found');
        }

        return $this->sendResponse($carsEvaluation->toArray(), 'Cars Evaluation retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCarsEvaluationAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/carsEvaluations/{id}",
     *      summary="Update the specified CarsEvaluation in storage",
     *      tags={"CarsEvaluation"},
     *      description="Update CarsEvaluation",
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
     *          description="id of CarsEvaluation",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CarsEvaluation that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/CarsEvaluation")
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
     *                  ref="#/definitions/CarsEvaluation"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCarsEvaluationAPIRequest $request)
    {
        $input = $request->all();

        /** @var CarsEvaluation $carsEvaluation */
        $carsEvaluation = $this->carsEvaluationRepository->findWithoutFail($id);

        if (empty($carsEvaluation)) {
            return $this->sendError('Cars Evaluation not found');
        }

        $carsEvaluation = $this->carsEvaluationRepository->update($input, $id);

        return $this->sendResponse($carsEvaluation->toArray(), 'CarsEvaluation updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * //@SWG\Delete(
     *      path="/carsEvaluations/{id}",
     *      summary="Remove the specified CarsEvaluation from storage",
     *      tags={"CarsEvaluation"},
     *      description="Delete CarsEvaluation",
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
     *          description="id of CarsEvaluation",
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
        /** @var CarsEvaluation $carsEvaluation */
        $carsEvaluation = $this->carsEvaluationRepository->findWithoutFail($id);

        if (empty($carsEvaluation)) {
            return $this->sendError('Cars Evaluation not found');
        }

        $carsEvaluation->delete();

        return $this->sendResponse($id, 'Cars Evaluation deleted successfully');
    }
}
