<?php

namespace App\Http\Controllers\Api;

use App\Criteria\CarsFilterCriteria;
use App\Criteria\CarsForBidsFilterCriteria;
use App\Http\Requests\Api\CreateMakeBidAPIRequest;
use App\Http\Requests\Api\UpdateMakeBidAPIRequest;
use App\Models\MakeBid;
use App\Models\User;
use App\Repositories\Admin\MakeBidRepository;
use App\Repositories\Admin\MyCarRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class MakeBidController
 * @package App\Http\Controllers\Api
 */
class MakeBidAPIController extends AppBaseController
{
    /** @var  MakeBidRepository */
    private $makeBidRepository;

    /** @var  MyCarRepository */
    private $carRepository;

    public function __construct(MakeBidRepository $makeBidRepo, MyCarRepository $carRepo)
    {
        $this->makeBidRepository = $makeBidRepo;
        $this->carRepository = $carRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/makeBids",
     *      summary="Get a listing of the Car.",
     *      tags={"Cars"},
     *      description="Get all MakeBids",
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
     *          name="favorite",
     *          description="Change the Default Offset of the Query. If not found, 0 will be used.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="category_id",
     *          description="Category Id",
     *          type="integer",
     *          required=true,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="brand_ids",
     *          description="Filter by Brands, CSV, [1,2,3]",
     *          required=false,
     *          type="string",
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="transmission_type",
     *          description="car transmission type: 10=Manual, 20=Automatic",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="min_price",
     *          description="car price min",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="max_price",
     *          description="car price max",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="min_year",
     *          description="car year min",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="max_year",
     *          description="car year max",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *      @SWG\Parameter(
     *          name="car_type",
     *          description="car type",
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
     *                  @SWG\Items(ref="#/definitions/MakeBid")
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
        $this->carRepository->pushCriteria(new RequestCriteria($request));
        $this->carRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->carRepository->pushCriteria(new CarsForBidsFilterCriteria($request));
        $makeBids = $this->carRepository->all();

        return $this->sendResponse($makeBids->toArray(), 'Make Bids retrieved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/makeBids/{id}",
     *      summary="Display the specified Car",
     *      tags={"Cars"},
     *      description="Get MakeBid",
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
     *          description="id of Car",
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
     *                  ref="#/definitions/MakeBid"
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
        /** @var MakeBid $car */
        $car = $this->carRepository->findWithoutFail($id);
        if (empty($car)) {
            return $this->sendError('Car not found');
        }

        return $this->sendResponse($car->toArray(), 'Car retrieved successfully');
    }

    /**
     * @param CreateMakeBidAPIRequest $request
     * @return Response
     *
     * //@SWG\Post(
     *      path="/makeBids",
     *      summary="Store a newly created MakeBid in storage",
     *      tags={"Cars"},
     *      description="Store MakeBid",
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
     *          name="car_id",
     *          description="Car id",
     *          type="integer",
     *          required=true,
     *          default="1",
     *          in="query"
     *      ),
     *      //@SWG\Parameter(
     *          name="amount",
     *          description="Bid Amount",
     *          type="integer",
     *          required=true,
     *          default="10000",
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
     *                  ref="#/definitions/MakeBid"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMakeBidAPIRequest $request)
    {
        $input = $request->all();

        $makeBids = $this->makeBidRepository->create($input);

        return $this->sendResponse($makeBids->toArray(), 'Make Bid saved successfully');
    }

    /**
     * @param int $id
     * @param UpdateMakeBidAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/makeBids/{id}",
     *      summary="Update the specified MakeBid in storage",
     *      tags={"Cars"},
     *      description="Update MakeBid",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of MakeBid",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MakeBid that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/MakeBid")
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
     *                  ref="#/definitions/MakeBid"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMakeBidAPIRequest $request)
    {
        $input = $request->all();

        /** @var MakeBid $makeBid */
        $makeBid = $this->makeBidRepository->findWithoutFail($id);

        if (empty($makeBid)) {
            return $this->sendError('Make Bid not found');
        }

        $makeBid = $this->makeBidRepository->update($input, $id);

        return $this->sendResponse($makeBid->toArray(), 'MakeBid updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * //@SWG\Delete(
     *      path="/makeBids/{id}",
     *      summary="Remove the specified MakeBid from storage",
     *      tags={"Cars"},
     *      description="Delete MakeBid",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of MakeBid",
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
        /** @var MakeBid $makeBid */
        $makeBid = $this->makeBidRepository->findWithoutFail($id);

        if (empty($makeBid)) {
            return $this->sendError('Make Bid not found');
        }

        $makeBid->delete();

        return $this->sendResponse($id, 'Make Bid deleted successfully');
    }
}
