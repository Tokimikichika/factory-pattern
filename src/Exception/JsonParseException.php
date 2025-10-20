<?php

namespace Tokimikichika\FactoryPattern\Exception;

/**
 * Исключение для ошибок парсинга JSON.
 */
class JsonParseException extends ParserException
{
    /**
     * @param string $jsonError - ошибка парсинга JSON
     * @return self - исключение для ошибок парсинга JSON
     */
    public static function fromJsonError(string $jsonError): self
    {
        return new self("Некорректный JSON: {$jsonError}");
    }

    /**
     * @return self - исключение для ошибок парсинга JSON
     */
    public static function invalidFormat(): self
    {
        return new self('JSON должен представлять объект или массив');
    }
}
