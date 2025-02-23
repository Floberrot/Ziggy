<?php

namespace App\Shared\Infrastructure\Http;

use App\Shared\Application\Query\QueryResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class ZiggyResponse extends JsonResponse
{
    public function __construct(string $message, ?QueryResponse $data = null, int $code = 200)
    {
        parent::__construct([
            'message' => $message,
            'data' => $data->getNormalizedData() ?? [],
        ], $code);
    }
}
