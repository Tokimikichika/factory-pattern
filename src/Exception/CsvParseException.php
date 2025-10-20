<?php

namespace Tokimikichika\FactoryPattern\Exception;

/**
 * Исключение для ошибок парсинга CSV.
 */
class CsvParseException extends ParserException
{
    /**
     * @return self - исключение для ошибок парсинга CSV
     */
    public static function columnMismatch(): self
    {
        return new self('CSV: количество столбцов не совпадает с заголовками');
    }

    /**
     * @return self - исключение для ошибок парсинга CSV
     */
    public static function invalidFormat(): self
    {
        return new self('CSV: некорректный формат данных');
    }
}
