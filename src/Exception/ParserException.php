<?php

namespace Tokimikichika\FactoryPattern\Exception;

/**
 * Базовое исключение для всех ошибок парсинга.
 */
class ParserException extends \Exception
{
    /**
     * @param string $message - сообщение об ошибке
     * @param int $code - код ошибки
     * @param \Throwable $previous - предыдущее исключение
     */
    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
