<?php

namespace App\Utils;

class AppConstant
{
    //  Pagination
    const PAGINATE = 50;

    //  Database Entity Status
    const STATUS_INACTIVE = false;
    const STATUS_ACTIVE = true;

    //  API Meta Status
    const STATUS_FAIL = false;
    const STATUS_OK = true;

    //  API Status Code
    const OK = 200;
    const CREATED = 201;
    const NO_CONTENT_SUCCESS = 204;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const CONFLICT_ERROR = 409;
    const UNPROCESSABLE_REQUEST = 422;
    const PRECONDITION_REQUIRE = 428;
    const INTERNAL_SERVER_ERROR = 500;
    const TOKEN_INVALID = 503;
}
