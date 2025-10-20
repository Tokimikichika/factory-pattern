<?php

namespace Tokimikichika\FactoryPattern\Exception;

/**
 * Исключение для ошибок парсинга XML.
 */
class XmlParseException extends ParserException
{
    /**
     * @param string $errorMessage - сообщение об ошибке
     * @return self - исключение для ошибок парсинга XML
     */
    public static function fromLibXmlError(string $errorMessage): self
    {
        return new self("Некорректный XML: {$errorMessage}");
    }

    /**
     * @return self - исключение для ошибок парсинга XML
     */
    public static function unknownError(): self
    {
        return new self('Некорректный XML: unknown error');
    }
}
