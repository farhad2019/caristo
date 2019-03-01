<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateContactUsAPIRequest;
use App\Http\Requests\Api\UpdateContactUsAPIRequest;
use App\Models\ContactUs;
use App\Repositories\Admin\BanksRateRepository;
use App\Repositories\Admin\ContactUsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ContactUsController
 * @package App\Http\Controllers\Api
 */
class ContactUsAPIController extends AppBaseController
{
    /** @var  ContactUsRepository */
    private $contactUsRepository;

    /** @var  BanksRateRepository */
    private $banksRateRepository;

    /**
     * ContactUsAPIController constructor.
     * @param ContactUsRepository $contactUsRepo
     * @param BanksRateRepository $banksRateRepo
     */
    public function __construct(ContactUsRepository $contactUsRepo, BanksRateRepository $banksRateRepo)
    {
        $this->contactUsRepository = $contactUsRepo;
        $this->banksRateRepository = $banksRateRepo;
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
     *          name="Authorization",
     *          description="User Auth Token{ Bearer ABC123 }",
     *          type="string",
     *          required=true,
     *          default="Bearer ABC123",
     *          in="header"
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
//        $this->contactUsRepository->pushCriteria(new RequestCriteria($request));
//        $this->contactUsRepository->pushCriteria(new LimitOffsetCriteria($request));
//        $contactus = $this->contactUsRepository->all();

        return $this->sendResponse(['Here you go'], 'contact us retrieved successfully');
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
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateContactUsAPIRequest $request)
    {
        $contactUs = $this->contactUsRepository->saveRecord($request);
        if ($request->type == ContactUs::BANK) {
            if ($contactUs->bankDetail->email){
                $email = $contactUs->bankDetail->email;
                $name = $contactUs->bankDetail->title;
                $subject = 'Virtual Buy Request.';

                Mail::send('email.virtualBuy', ['name' => $name],
                    function ($mail) use ($email, $name, $subject) {
                        $mail->from(getenv('MAIL_FROM_ADDRESS'), "CaristoCrat App");
                        $mail->to($email, $name);
                        $mail->subject($subject);
                    });
            }
        }
        return $this->sendResponse($contactUs->toArray(), 'Contact Us saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * //@SWG\Get(
     *      path="/contactus/{id}",
     *      summary="Display the specified ContactUs",
     *      tags={"ContactUs"},
     *      description="Get ContactUs",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of ContactUs",
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
     *                  ref="#/definitions/ContactUs"
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
     * //@SWG\Put(
     *      path="/contactus/{id}",
     *      summary="Update the specified ContactUs in storage",
     *      tags={"ContactUs"},
     *      description="Update ContactUs",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of ContactUs",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      //@SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ContactUs that should be updated",
     *          required=false,
     *          //@SWG\Schema(ref="#/definitions/ContactUs")
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
     *                  ref="#/definitions/ContactUs"
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
     * @throws \Exception
     *
     * //@SWG\Delete(
     *      path="/contactus/{id}",
     *      summary="Remove the specified ContactUs from storage",
     *      tags={"ContactUs"},
     *      description="Delete ContactUs",
     *      produces={"application/json"},
     *      //@SWG\Parameter(
     *          name="id",
     *          description="id of ContactUs",
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
        /** @var ContactUs $contactUs */
        $contactUs = $this->contactUsRepository->findWithoutFail($id);

        if (empty($contactUs)) {
            return $this->sendError('Contact Us not found');
        }

        $contactUs->delete();

        return $this->sendResponse($id, 'Contact Us deleted successfully');
    }
}
