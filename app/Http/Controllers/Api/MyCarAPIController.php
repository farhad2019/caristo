<?php

namespace App\Http\Controllers\Api;

use App\Criteria\CarsFilterCriteria;
use App\Http\Requests\Api\CreateMyCarAPIRequest;
use App\Http\Requests\Api\UpdateMyCarAPIRequest;
use App\Models\MyCar;
use App\Repositories\Admin\CarAttributeRepository;
use App\Repositories\Admin\CarFeatureRepository;
use App\Repositories\Admin\MyCarRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class MyCarController
 * @package App\Http\Controllers\Api
 */
class MyCarAPIController extends AppBaseController
{
    /** @var  MyCarRepository */
    private $myCarRepository;

    /** @var  CarAttributeRepository */
    private $attributeRepository;

    /** @var  CarFeatureRepository */
    private $featureRepository;

    /**
     * MyCarAPIController constructor.
     * @param MyCarRepository $myCarRepo
     * @param CarAttributeRepository $attributeRepo
     * @param CarFeatureRepository $featureRepo
     */
    public function __construct(MyCarRepository $myCarRepo, CarAttributeRepository $attributeRepo, CarFeatureRepository $featureRepo)
    {
        $this->myCarRepository = $myCarRepo;
        $this->attributeRepository = $attributeRepo;
        $this->featureRepository = $featureRepo;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     * @SWG\Get(
     *      path="/myCars",
     *      summary="Get a listing of the MyCars.",
     *      tags={"MyCar"},
     *      description="Get all MyCars",
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
     *                  @SWG\Items(ref="#/definitions/MyCar")
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
        $this->myCarRepository->pushCriteria(new RequestCriteria($request));
        $this->myCarRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->myCarRepository->pushCriteria(new CarsFilterCriteria($request));
        $myCars = $this->myCarRepository->all();

        return $this->sendResponse($myCars->toArray(), 'My Cars retrieved successfully');
    }

    /**
     * @param CreateMyCarAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/myCars",
     *      summary="Store a newly created MyCar in storage",
     *      tags={"MyCar"},
     *      description="Store MyCar",
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
     *          description="MyCar that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MyCar")
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
     *                  ref="#/definitions/MyCar"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMyCarAPIRequest $request)
    {
        $myCars = $this->myCarRepository->saveRecord($request);

        if (is_string($request->car_attributes)) {
            if (!empty(json_decode($request->car_attributes))) {
                foreach (json_decode($request->car_attributes) as $key => $car_attribute) {
                    $attribute = $this->attributeRepository->findWhere(['id' => array_keys(get_object_vars($car_attribute))[0]]);

                    if ($attribute->count() > 0) {
                        $myCars->carAttributes()->attach(array_keys(get_object_vars($car_attribute))[0], ['value' => array_values(get_object_vars($car_attribute))[0]]);
                    }
                }
            }
        } elseif (is_array($request->car_attributes)) {
            if (!empty($request->car_attributes)) {
                foreach ($request->car_attributes as $key => $car_attribute) {
                    $attribute = $this->attributeRepository->findWhere(['id' => array_keys($car_attribute)[0]]);
                    if ($attribute->count() > 0) {
                        $myCars->carAttributes()->attach(array_keys($car_attribute)[0], ['value' => array_values($car_attribute)[0]]);
                    }
                }
            }
        }
        
        if (is_string($request->car_features)) {
            if (!empty(json_decode($request->car_features))) {
                $myCars->carFeatures()->attach(json_decode($request->car_features));
            }
        } elseif (is_array($request->car_features)) {
            if (!empty($request->car_features)) {
                $myCars->carFeatures()->attach($request->car_features);
            }
        }

        /*if (!empty($request->car_features)) {
//            foreach ($request->car_features as $key => $car_feature) {
//                $feature = $this->featureRepository->findWhere(['id' => $car_feature]);
//                if ($feature->count() > 0) {
//
//                }
//            }
            if (is_string($request->car_attributes)) {
                $bool = empty(json_decode($request->car_features));
                $features = json_decode($request->car_features);
            } elseif (is_array($request->car_attributes)) {
                $features = $request->car_features;
            }
            $myCars->carFeatures()->attach($features);
        }*/
        $myCars = $this->myCarRepository->findWithoutFail($myCars->id);
        return $this->sendResponse($myCars->toArray(), 'My Car saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/myCars/{id}",
     *      summary="Display the specified MyCar",
     *      tags={"MyCar"},
     *      description="Get MyCar",
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
     *          description="id of MyCar",
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
     *                  ref="#/definitions/MyCar"
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
        /** @var MyCar $myCar */
        $myCar = $this->myCarRepository->findWithoutFail($id);

        if (empty($myCar)) {
            return $this->sendError('My Car not found');
        }

        return $this->sendResponse($myCar->toArray(), 'My Car retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateMyCarAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/myCars/{id}",
     *      summary="Update the specified MyCar in storage",
     *      tags={"MyCar"},
     *      description="Update MyCar",
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
     *          description="id of MyCar",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MyCar that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MyCar")
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
     *                  ref="#/definitions/MyCar"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMyCarAPIRequest $request)
    {
        /** @var MyCar $myCar */
        $myCar = $this->myCarRepository->findWithoutFail($id);
        if (empty($myCar)) {
            return $this->sendError('My Car not found');
        }

        $myCar = $this->myCarRepository->updateRecord($request, $myCar);
        return $this->sendResponse($myCar->toArray(), 'MyCar updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     * @throws \Exception
     *
     * @SWG\Delete(
     *      path="/myCars/{id}",
     *      summary="Remove the specified MyCar from storage",
     *      tags={"MyCar"},
     *      description="Delete MyCar",
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
     *          description="id of MyCar",
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
        /** @var MyCar $myCar */
        $myCar = $this->myCarRepository->findWithoutFail($id);

        if (empty($myCar)) {
            return $this->sendError('My Car not found');
        }

        $myCar->delete();

        return $this->sendResponse($id, 'My Car deleted successfully');
    }
}
