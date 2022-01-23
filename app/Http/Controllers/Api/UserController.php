<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse|object
     */
    public function getUser(Request $request): JsonResponse
    {
        return (new UserResource($request->user()))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
