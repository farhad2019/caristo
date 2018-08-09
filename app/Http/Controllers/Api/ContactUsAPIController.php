<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateContactUsAPIRequest;
use App\Http\Requests\Api\UpdateContactUsAPIRequest;
use App\Models\ContactUs;
use App\Repositories\Admin\ContactUsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ContactUsController
 * @package App\Http\Controllers\Api
 */

class ContactUsAPIController extends AppBaseController
{
    /** @var  ContactUsRepository */
    private $contactUsRepository;

    public function __construct(ContactUsRepository $contactUsRepo)
    {
        $this->contactUsRepository = $contactUsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/contactus",
     *      summary="Get a listing of the contactus.",
     *      tags={"ContactUs"},
     *      description="Get all contactus",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="limit",
     *          description="Change the Default Record Count. If not found, Returns All Records in DB.",
     *          type="integer",
     *          required=false,
     *          in="query"
     *      ),
     *     @SWG\Parameter(
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
     *                  @SWG\Items(ref="#/definitions/ContactUs")
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
        $this->contactUsRepository->pushCriteria(new RequestCriteria($request));
        $this->contactUsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $contactus = $this->contactUsRepository->all();

        return $this->sendResponse($contactus->toArray(), 'contactus retrieved successfully');
    }

    /**
     * @param CreateContactUsAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/contactus",
     *      summary="Store a newly created ContactUs in storage",
     *      tags={"ContactUs"},
     *      description="Store ContactUs",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ContactUs that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ContactUs")
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
     *                  ref="#/definitions/ContactUs"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateContactUsAPIRequest $request)
    {
        $input = $request->all();

        $contactus = $this->contactUsRepository->create($input);

        return $this->sendResponse($contactus->toArray(), 'Contact Us saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/contactus/{id}",
     *      summary="Display the specified ContactUs",
     *      tags={"ContactUs"},
     *      description="Get ContactUs",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ContactUs",
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
     *                  ref="#/definitions/ContactUs"
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
        /** @var ContactUs $contactUs */
        $contactUs = $this->contactUsRepository->findWithoutFail($id);

        if (empty($contactUs)) {
            return $this->sendError('Contact Us not found');
        }

        return $this->sendResponse($contactUs->toArray(), 'Contact Us retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateContactUsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/contactus/{id}",
     *      summary="Update the specified ContactUs in storage",
     *      tags={"ContactUs"},
     *      description="Update ContactUs",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ContactUs",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ContactUs that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ContactUs")
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
     *                  ref="#/definitions/ContactUs"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateContactUsAPIRequest $request)
    {
        $input = $request->all();

        /** @var ContactUs $contactUs */
        $contactUs = $this->contactUsRepository->findWithoutFail($id);

        if (empty($contactUs)) {
            return $this->sendError('Contact Us not found');
        }

        $contactUs = $this->contactUsRepository->update($input, $id);

        return $this->sendResponse($contactUs->toArray(), 'ContactUs updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/contactus/{id}",
     *      summary="Remove the specified ContactUs from storage",
     *      tags={"ContactUs"},
     *      description="Delete ContactUs",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ContactUs",
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
        /** @var ContactUs $contactUs */
        $contactUs = $this->contactUsRepository->findWithoutFail($id);

        if (empty($contactUs)) {
            return $this->sendError('Contact Us not found');
        }

        $contactUs->delete();

        return $this->sendResponse($id, 'Contact Us deleted successfully');
    }
}
