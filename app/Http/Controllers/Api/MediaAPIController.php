<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CreateMediaAPIRequest;
use App\Http\Requests\Api\UpdateMediaAPIRequest;
use App\Models\Media;
use App\Repositories\Admin\MediaRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class MediaController
 * @package App\Http\Controllers\Api
 */

class MediaAPIController extends AppBaseController
{
    /** @var  MediaRepository */
    private $mediaRepository;

    public function __construct(MediaRepository $mediaRepo)
    {
        $this->mediaRepository = $mediaRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/media",
     *      summary="Get a listing of the Media.",
     *      tags={"Media"},
     *      description="Get all Media",
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
     *                  @SWG\Items(ref="#/definitions/Media")
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
        $this->mediaRepository->pushCriteria(new RequestCriteria($request));
        $this->mediaRepository->pushCriteria(new LimitOffsetCriteria($request));
        $media = $this->mediaRepository->all();

        return $this->sendResponse($media->toArray(), 'Media retrieved successfully');
    }

    /**
     * @param CreateMediaAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/media",
     *      summary="Store a newly created Media in storage",
     *      tags={"Media"},
     *      description="Store Media",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Media that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Media")
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
     *                  ref="#/definitions/Media"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMediaAPIRequest $request)
    {
        $input = $request->all();

        $media = $this->mediaRepository->create($input);

        return $this->sendResponse($media->toArray(), 'Media saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/media/{id}",
     *      summary="Display the specified Media",
     *      tags={"Media"},
     *      description="Get Media",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Media",
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
     *                  ref="#/definitions/Media"
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
        /** @var Media $media */
        $media = $this->mediaRepository->findWithoutFail($id);

        if (empty($media)) {
            return $this->sendError('Media not found');
        }

        return $this->sendResponse($media->toArray(), 'Media retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateMediaAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/media/{id}",
     *      summary="Update the specified Media in storage",
     *      tags={"Media"},
     *      description="Update Media",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Media",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Media that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Media")
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
     *                  ref="#/definitions/Media"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMediaAPIRequest $request)
    {
        $input = $request->all();

        /** @var Media $media */
        $media = $this->mediaRepository->findWithoutFail($id);

        if (empty($media)) {
            return $this->sendError('Media not found');
        }

        $media = $this->mediaRepository->update($input, $id);

        return $this->sendResponse($media->toArray(), 'Media updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/media/{id}",
     *      summary="Remove the specified Media from storage",
     *      tags={"Media"},
     *      description="Delete Media",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Media",
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
        /** @var Media $media */
        $media = $this->mediaRepository->findWithoutFail($id);

        if (empty($media)) {
            return $this->sendError('Media not found');
        }

        $media->delete();

        return $this->sendResponse($id, 'Media deleted successfully');
    }
}
