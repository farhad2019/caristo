<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateSubscriberAPIRequest;
use App\Http\Requests\Api\UpdateSubscriberAPIRequest;
use App\Models\Subscriber;
use App\Repositories\Admin\SubscriberRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

/**
 * Class SubscriberController
 * @package App\Http\Controllers\Api
 */
class SubscriberAPIController extends AppBaseController
{
    /** @var  SubscriberRepository */
    private $subscriberRepository;

    public function __construct(SubscriberRepository $subscriberRepo)
    {
        $this->subscriberRepository = $subscriberRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * //@SWG\Get(
     *      path="/subscribers",
     *      summary="Get a listing of the Subscribers.",
     *      tags={"Subscriber"},
     *      description="Get all Subscribers",
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
     *                  //@SWG\Items(ref="#/definitions/Subscriber")
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
        $this->subscriberRepository->pushCriteria(new RequestCriteria($request));
        $this->subscriberRepository->pushCriteria(new LimitOffsetCriteria($request));
        $subscribers = $this->subscriberRepository->all();

        return $this->sendResponse($subscribers->toArray(), 'Subscribers retrieved successfully');
    }

    /**
     * @param CreateSubscriberAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/subscribers",
     *      summary="Store a newly created Subscriber in storage",
     *      tags={"Subscriber"},
     *      description="Store Subscriber",
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
     *          description="Subscriber that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Subscriber")
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
     *                  ref="#/definitions/Subscriber"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateSubscriberAPIRequest $request)
    {
        $input = $request->all();

        $subscribers = $this->subscriberRepository->create($input);

        return $this->sendResponse($subscribers->toArray(), 'Subscriber saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Get(
     *      path="/subscribers/{id}",
     *      summary="Display the specified Subscriber",
     *      tags={"Subscriber"},
     *      description="Get Subscriber",
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
     *          description="id of Subscriber",
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
     *                  ref="#/definitions/Subscriber"
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
        /** @var Subscriber $subscriber */
        $subscriber = $this->subscriberRepository->findWithoutFail($id);

        if (empty($subscriber)) {
            return $this->sendError('Subscriber not found');
        }

        return $this->sendResponse($subscriber->toArray(), 'Subscriber retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSubscriberAPIRequest $request
     * @return Response
     *
     * //@SWG\Put(
     *      path="/subscribers/{id}",
     *      summary="Update the specified Subscriber in storage",
     *      tags={"Subscriber"},
     *      description="Update Subscriber",
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
     *          description="id of Subscriber",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Subscriber that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/Subscriber")
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
     *                  ref="#/definitions/Subscriber"
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
    public function update($id, UpdateSubscriberAPIRequest $request)
    {
        $input = $request->all();

        /** @var Subscriber $subscriber */
        $subscriber = $this->subscriberRepository->findWithoutFail($id);

        if (empty($subscriber)) {
            return $this->sendError('Subscriber not found');
        }

        $subscriber = $this->subscriberRepository->update($input, $id);

        return $this->sendResponse($subscriber->toArray(), 'Subscriber updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * //@SWG\Delete(
     *      path="/subscribers/{id}",
     *      summary="Remove the specified Subscriber from storage",
     *      tags={"Subscriber"},
     *      description="Delete Subscriber",
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
     *          description="id of Subscriber",
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
        /** @var Subscriber $subscriber */
        $subscriber = $this->subscriberRepository->findWithoutFail($id);

        if (empty($subscriber)) {
            return $this->sendError('Subscriber not found');
        }

        $subscriber->delete();

        return $this->sendResponse($id, 'Subscriber deleted successfully');
    }
}
