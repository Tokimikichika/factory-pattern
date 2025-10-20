<?php

namespace Tokimikichika\FactoryPattern\Parser;

use Tokimikichika\FactoryPattern\Exception\CsvParseException;
use Tokimikichika\FactoryPattern\Interface\ParserInterface;

// Парсер CSV данных
class CsvParser implements ParserInterface
{
    /**
     * Преобразовать входную строку CSV в ассоциативный массив.
     *
     * @throws CsvParseException
     */
    public function parse(string $input): array
    {
        $lines = preg_split("/(\r\n|\r|\n)/", trim($input));
        if ($lines === false || $lines === []) {
            return [];
        }

        $rows    = [];
        $headers = null;
        foreach ($lines as $line) {
            $stream = fopen('php://temp', 'r+');
            fwrite($stream, $line);
            rewind($stream);
            $parsed = fgetcsv($stream);
            fclose($stream);

            if ($parsed === false) {
                continue;
            }
            if ($headers === null) {
                $headers = $parsed;
                continue;
            }

            if (count($headers) !== count($parsed)) {
                throw CsvParseException::columnMismatch();
            }

            $combined = array_combine($headers, $parsed);
            $rows[]   = $combined;
        }

        return $rows;
    }
}
