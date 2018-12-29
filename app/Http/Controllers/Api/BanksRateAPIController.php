<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateBanksRateAPIRequest;
use App\Http\Requests\Api\UpdateBanksRateAPIRequest;
use App\Models\BanksRate;
use App\Repositories\Admin\BanksRateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class BanksRateController
 * @package App\Http\Controllers\Api
 */

class BanksRateAPIController extends AppBaseController
{
    /** @var  BanksRateRepository */
    private $banksRateRepository;

    public function __construct(BanksRateRepository $banksRateRepo)
    {
        $this->banksRateRepository = $banksRateRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/banksRates",
     *      summary="Get a listing of the BanksRates.",
     *      tags={"BanksRate"},
     *      description="Get all BanksRates",
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
     *                  @SWG\Items(ref="#/definitions/BanksRate")
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
        $this->banksRateRepository->pushCriteria(new RequestCriteria($request));
        $this->banksRateRepository->pushCriteria(new LimitOffsetCriteria($request));
        $banksRates = $this->banksRateRepository->all();

        return $this->sendResponse($banksRates->toArray(), 'Banks Rates retrieved successfully');
    }

    /**
     * @param CreateBanksRateAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/banksRates",
     *      summary="Store a newly created BanksRate in storage",
     *      tags={"BanksRate"},
     *      description="Store BanksRate",
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
     *          name="body",
     *          in="body",
     *          description="BanksRate that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/BanksRate")
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
     *                  ref="#/definitions/BanksRate"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateBanksRateAPIRequest $request)
    {
        $input = $request->all();

        $banksRates = $this->banksRateRepository->create($input);

        return $this->sendResponse($banksRates->toArray(), 'Banks Rate saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/banksRates/{id}",
     *      summary="Display the specified BanksRate",
     *      tags={"BanksRate"},
     *      description="Get BanksRate",
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
     *          name="id",
     *          description="id of BanksRate",
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
     *                  ref="#/definitions/BanksRate"
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
        /** @var BanksRate $banksRate */
        $banksRate = $this->banksRateRepository->findWithoutFail($id);

        if (empty($banksRate)) {
            return $this->sendError('Banks Rate not found');
        }

        return $this->sendResponse($banksRate->toArray(), 'Banks Rate retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateBanksRateAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/banksRates/{id}",
     *      summary="Update the specified BanksRate in storage",
     *      tags={"BanksRate"},
     *      description="Update BanksRate",
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
     *          name="id",
     *          description="id of BanksRate",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="BanksRate that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/BanksRate")
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
     *                  ref="#/definitions/BanksRate"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateBanksRateAPIRequest $request)
    {
        $input = $request->all();

        /** @var BanksRate $banksRate */
        $banksRate = $this->banksRateRepository->findWithoutFail($id);

        if (empty($banksRate)) {
            return $this->sendError('Banks Rate not found');
        }

        $banksRate = $this->banksRateRepository->update($input, $id);

        return $this->sendResponse($banksRate->toArray(), 'BanksRate updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * @SWG\Delete(
     *      path="/banksRates/{id}",
     *      summary="Remove the specified BanksRate from storage",
     *      tags={"BanksRate"},
     *      description="Delete BanksRate",
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
     *          name="id",
     *          description="id of BanksRate",
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
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var BanksRate $banksRate */
        $banksRate = $this->banksRateRepository->findWithoutFail($id);

        if (empty($banksRate)) {
            return $this->sendError('Banks Rate not found');
        }

        $banksRate->delete();

        return $this->sendResponse($id, 'Banks Rate deleted successfully');
    }
}
