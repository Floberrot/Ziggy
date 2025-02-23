<?php

namespace App\Shared\Infrastructure\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class ExceptionResponse extends JsonResponse
{
    public function __construct(Throwable $t)
    {
        $code = self::isPostgresSQLErrorCode($t->getCode()) ? 500 : $t->getCode();

        parent::__construct([
            'message' => $t->getMessage(),
            'code' => $code,
        ], $code);
    }

    private static function isPostgresSQLErrorCode(int $code): bool
    {
        $length = strlen((string) abs($code));

        return $length <= 1 || $length > 5;
    }
}
