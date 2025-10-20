<?php

namespace Tokimikichika\FactoryPattern\Tests\Parser;

use PHPUnit\Framework\TestCase;
use Tokimikichika\FactoryPattern\Exception\JsonParseException;
use Tokimikichika\FactoryPattern\Parser\JsonParser;

/**
 * Тесты для парсера JSON.
 */
class JsonParserTest extends TestCase
{
    private JsonParser $parser;

    protected function setUp(): void
    {
        $this->parser = new JsonParser();
    }

    /**
     * Тест для парсинга корректного JSON объекта.
     */
    public function testParseValidJsonObject(): void
    {
        $input    = '{"name":"John","age":30}';
        $expected = ['name' => 'John', 'age' => 30];

        $result = $this->parser->parse($input);

        $this->assertEquals($expected, $result);
    }

    /**
     * Тест для парсинга корректного JSON массива.
     */
    public function testParseValidJsonArray(): void
    {
        $input    = '[1,2,3,4,5]';
        $expected = [1, 2, 3, 4, 5];

        $result = $this->parser->parse($input);

        $this->assertEquals($expected, $result);
    }

    /**
     * Тест для парсинга пустого JSON объекта.
     */
    public function testParseEmptyJsonObject(): void
    {
        $input    = '{}';
        $expected = [];

        $result = $this->parser->parse($input);

        $this->assertEquals($expected, $result);
    }

    /**
     * Тест для парсинга пустого JSON массива.
     */
    public function testParseEmptyJsonArray(): void
    {
        $input    = '[]';
        $expected = [];

        $result = $this->parser->parse($input);

        $this->assertEquals($expected, $result);
    }

    /**
     * Тест для парсинга некорректного JSON объекта.
     */
    public function testParseInvalidJsonThrowsException(): void
    {
        $input = '{"name":"John",}';

        $this->expectException(JsonParseException::class);
        $this->expectExceptionMessage('Некорректный JSON:');

        $this->parser->parse($input);
    }

    /**
     * Тест для парсинга некорректного JSON массива.
     */
    public function testParseNonArrayJsonThrowsException(): void
    {
        $input = '"just a string"';

        $this->expectException(JsonParseException::class);
        $this->expectExceptionMessage('JSON должен представлять объект или массив');

        $this->parser->parse($input);
    }

    /**
     * Тест для парсинга некорректного JSON числа.
     */
    public function testParseNumberJsonThrowsException(): void
    {
        $input = '123';

        $this->expectException(JsonParseException::class);
        $this->expectExceptionMessage('JSON должен представлять объект или массив');

        $this->parser->parse($input);
    }
}
