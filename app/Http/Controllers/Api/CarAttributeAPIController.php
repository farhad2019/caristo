<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateCarAttributeAPIRequest;
use App\Http\Requests\Api\UpdateCarAttributeAPIRequest;
use App\Models\AttributeOption;
use App\Models\CarAttribute;
use App\Repositories\Admin\CarAttributeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class CarAttributeController
 * @package App\Http\Controllers\Api
 */
class CarAttributeAPIController extends AppBaseController
{
    /** @var  CarAttributeRepository */
    private $carAttributeRepository;

    public function __construct(CarAttributeRepository $carAttributeRepo)
    {
        $this->carAttributeRepository = $carAttributeRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/carAttributes",
     *      summary="Get a listing of the CarAttributes.",
     *      tags={"CarAttribute"},
     *      description="Get all CarAttributes",
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
     *                  @SWG\Items(ref="#/definitions/CarAttribute")
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
        $this->carAttributeRepository->pushCriteria(new RequestCriteria($request));
        $this->carAttributeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $carAttributes = $this->carAttributeRepository->all();

        return $this->sendResponse($carAttributes->toArray(), 'Car Attributes retrieved successfully');
    }

    /**
     * @param CreateCarAttributeAPIRequest $request
     * @return Response
     *
     * //@SWG\Post(
     *      path="/carAttributes",
     *      summary="Store a newly created CarAttribute in storage",
     *      tags={"CarAttribute"},
     *      description="Store CarAttribute",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CarAttribute that should be stored",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/CarAttribute")
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
     *                  ref="#/definitions/CarAttribute"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCarAttributeAPIRequest $request)
    {
        $input = $request->all();

        $carAttributes = $this->carAttributeRepository->create($input);

        return $this->sendResponse($carAttributes->toArray(), 'Car Attribute saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/carAttributes/{id}",
     *      summary="Display the specified CarAttribute",
     *      tags={"CarAttribute"},
     *      description="Get CarAttribute",
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
     *          description="id of CarAttribute",
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
     *                  ref="#/definitions/CarAttribute"
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
        /** @var CarAttribute $carAttribute */
        $carAttribute = $this->carAttributeRepository->findWithoutFail($id);
        if (empty($carAttribute)) {
            return $this->sendError('Car Attribute not found');
        }

        return $this->sendResponse($carAttribute->toArray(), 'Car Attribute retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCarAttributeAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/carAttributes/{id}",
     *      summary="Update the specified CarAttribute in storage",
     *      tags={"CarAttribute"},
     *      description="Update CarAttribute",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of CarAttribute",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CarAttribute that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/CarAttribute")
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
     *                  ref="#/definitions/CarAttribute"
     *              ),
     *              //@SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCarAttributeAPIRequest $request)
    {
        $input = $request->all();

        /** @var CarAttribute $carAttribute */
        $carAttribute = $this->carAttributeRepository->findWithoutFail($id);

        if (empty($carAttribute)) {
            return $this->sendError('Car Attribute not found');
        }

        $carAttribute = $this->carAttributeRepository->update($input, $id);

        return $this->sendResponse($carAttribute->toArray(), 'CarAttribute updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * //@SWG\Delete(
     *      path="/carAttributes/{id}",
     *      summary="Remove the specified CarAttribute from storage",
     *      tags={"CarAttribute"},
     *      description="Delete CarAttribute",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of CarAttribute",
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
        /** @var CarAttribute $carAttribute */
        $carAttribute = $this->carAttributeRepository->findWithoutFail($id);

        if (empty($carAttribute)) {
            return $this->sendError('Car Attribute not found');
        }

        $carAttribute->delete();

        return $this->sendResponse($id, 'Car Attribute deleted successfully');
    }
}