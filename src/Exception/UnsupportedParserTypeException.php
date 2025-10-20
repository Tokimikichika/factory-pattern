<?php

namespace Tokimikichika\FactoryPattern\Exception;

/**
 * Исключение для неподдерживаемых типов парсеров.
 */
class UnsupportedParserTypeException extends ParserException
{
    /**
     * @param string $type - неподдерживаемый тип парсера
     * @param array $supportedTypes - список поддерживаемых типов
     * @return self - исключение для неподдерживаемых типов парсеров
     */
    public static function create(string $type, array $supportedTypes): self
    {
        $supportedList = implode(', ', $supportedTypes);

        return new self("Неизвестный тип парсера: {$type}. Поддерживаемые типы: {$supportedList}");
    }
}
