<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdvertRequest;
use App\Http\Requests\GetAdvertRequest;
use App\Http\Resources\AdvertResource;
use App\Http\Resources\AdvertsResource;
use App\Services\AdvertService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Lang;

class AdvertController extends Controller
{

    /**
     * @param CreateAdvertRequest $request
     * @param AdvertService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function createAdvert(CreateAdvertRequest $request, AdvertService $service)
    {
        try {
            $advertID = $service->addAdvert($request->all());
            $json     = [
                'success' => 1,
                'data'    => [
                    'advert_id' => $advertID
                ]
            ];

            return response()->json($json);
        } catch (\Exception $e) {
            return $this->apiErrorResponse();
        }
    }

    /**
     * @param GetAdvertRequest $request
     * @param AdvertService $service
     * @param string | int $id
     * @return AdvertResource |\Illuminate\Http\JsonResponse
     */
    public function getAdvert(GetAdvertRequest $request, AdvertService $service, $id)
    {
        try {
            $fields = $request->fields ?? [];

            $getDescription = in_array('description', $fields);
            $getAllPhoto    = in_array('all_photos', $fields);

            $advert = $service->getAdvert($id, $getDescription, $getAllPhoto);

            return new AdvertResource($advert);
        } catch (ModelNotFoundException $e) {
            $json = [
                'success' => 0,
                'errors'  => ['Advert not found']
            ];

            return response()->json($json, 404);
        } catch (\Exception $e) {
            return $this->apiErrorResponse();
        }
    }

    /**
     * @param Request $request
     * @param AdvertService $service
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getAdverts(Request $request, AdvertService $service)
    {
        try {
            $adverts = $service->getAdverts($request->sort, $request->sort_direction);

            return AdvertsResource::collection($adverts);
        } catch (\Exception $e) {
            return $this->apiErrorResponse();
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function apiErrorResponse()
    {
        $json = [
            'success' => 0,
            'errors'  => [trans('messages.api_error')]
        ];

        return response()->json($json, 500);
    }

}
