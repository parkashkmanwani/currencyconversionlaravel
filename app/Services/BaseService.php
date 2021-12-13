<?php

declare(strict_types=1);

namespace App\Services;

class BaseService
{
    /**
     * Success Response
     *
     * @param $response
     * @param int $statusCode
     *
     * @return array
     */
    public function sendSuccessResponse($response, int $statusCode = 200): array
    {
        return [$response, $statusCode];
    }

    /**
     * Failure Response
     *
     * @param mixed $response
     * @param int $statusCode
     *
     * @return array
     */
    public function sendFailureResponse($response, int $statusCode = 500): array
    {
        return [$response, $statusCode];
    }
}
