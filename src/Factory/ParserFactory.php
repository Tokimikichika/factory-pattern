<?php

namespace Tokimikichika\FactoryPattern\Factory;

use Tokimikichika\FactoryPattern\Exception\UnsupportedParserTypeException;
use Tokimikichika\FactoryPattern\Interface\ParserInterface;
use Tokimikichika\FactoryPattern\Parser\CsvParser;
use Tokimikichika\FactoryPattern\Parser\JsonParser;
use Tokimikichika\FactoryPattern\Parser\XmlParser;

/**
 * Фабрика для создания парсеров данных.
 *
 * Реализует паттерн "Фабричный метод" для создания парсеров
 * различных форматов данных (JSON, XML, CSV)
 */
class ParserFactory
{
    /**
     * Создать парсер по типу.
     *
     * @param string $type - тип парсера: json, xml, csv
     * @return ParserInterface - экземпляр парсера
     * @throws UnsupportedParserTypeException - если тип парсера не поддерживается
     */
    public static function create(string $type): ParserInterface
    {
        return match (strtolower($type)) {
            'json'  => new JsonParser(),
            'xml'   => new XmlParser(),
            'csv'   => new CsvParser(),
            default => throw UnsupportedParserTypeException::create($type, self::getSupportedTypes()),
        };
    }

    /**
     * Получить список поддерживаемых типов парсеров.
     *
     * @return array - массив поддерживаемых типов: json, xml, csv
     */
    public static function getSupportedTypes(): array
    {
        return ['json', 'xml', 'csv'];
    }

    /**
     * Проверить, поддерживается ли указанный тип парсера.
     *
     * @param string $type - тип парсера для проверки
     * @return bool - true если тип поддерживается
     */
    public static function isSupported(string $type): bool
    {
        return in_array(strtolower($type), self::getSupportedTypes(), true);
    }
}
