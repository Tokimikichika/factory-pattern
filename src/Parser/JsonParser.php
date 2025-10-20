<?php

namespace Tokimikichika\FactoryPattern\Parser;

use Tokimikichika\FactoryPattern\Exception\JsonParseException;
use Tokimikichika\FactoryPattern\Interface\ParserInterface;

// Парсер JSON данных
class JsonParser implements ParserInterface
{
    /**
     * Преобразовать входную строку JSON в ассоциативный массив.
     *
     * @param string $input - входная строка JSON
     * @return array - ассоциативный массив данных
     * @throws JsonParseException
     */
    public function parse(string $input): array
    {
        $data = json_decode($input, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw JsonParseException::fromJsonError(json_last_error_msg());
        }
        if (!\is_array($data)) {
            throw JsonParseException::invalidFormat();
        }

        return $data;
    }
}
