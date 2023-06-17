<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait AuthTrait
{
    private $successCode = Response::HTTP_OK;
    private $internalServerErrorCode = Response::HTTP_INTERNAL_SERVER_ERROR;
    private $badRequestCode = Response::HTTP_BAD_REQUEST;

    private $unauthorized = Response::HTTP_UNAUTHORIZED;
    private $createdCode = Response::HTTP_CREATED;
}
