<?php

namespace App\Helper;

final class REST_Response
{
    public const SUCCESS                = 200;
    public const CREATED                = 201;
    public const NO_CONTENT             = 204;
    public const ERROR                  = 500;
    public const NOT_FOUND              = 404;
    public const UNAUTHORIZED           = 401;
    public const FORBIDDEN              = 403;
    public const BAD_REQUEST            = 400;
    public const SERVER_ERROR           = 500;
    public const NOT_IMPLEMENTED        = 501;
    public const SERVICE_UNAVAILABLE    = 503;
}
