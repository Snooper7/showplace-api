<?php
// Обработчик ошибок, выводящий их в таком же JSON формате
class ErrorHandler
{
    public static function handleException(Throwable $exception): void
    {
        http_response_code(500);
        echo json_encode([
            "code" => $exception->getCode(),
            "message" => $exception->getMessage(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine(),
        ]);
    }

    public static function handleError(
        int $errno,
        string $errstr,
        string $errfile,
        int $errline
    ): bool
    {
        throw new ErrorException($errno, 0, $errstr, $errfile, $errline);
    }
}