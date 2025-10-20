<?php

namespace Tokimikichika\FactoryPattern\Tests\Parser;

use PHPUnit\Framework\TestCase;
use Tokimikichika\FactoryPattern\Exception\CsvParseException;
use Tokimikichika\FactoryPattern\Parser\CsvParser;

/**
 * Тесты для парсера CSV.
 */
class CsvParserTest extends TestCase
{
    private CsvParser $parser;

    protected function setUp(): void
    {
        $this->parser = new CsvParser();
    }

    /**
     * Тест для парсинга корректного CSV файла.
     */
    public function testParseValidCsv(): void
    {
        $input    = "name,age,city\nJohn,30,New York\nJane,25,London";
        $expected = [
            ['name' => 'John', 'age' => '30', 'city' => 'New York'],
            ['name' => 'Jane', 'age' => '25', 'city' => 'London'],
        ];

        $result = $this->parser->parse($input);

        $this->assertEquals($expected, $result);
    }

    /**
     * Тест для парсинга CSV с кавычками.
     */
    public function testParseCsvWithQuotes(): void
    {
        $input    = "name,description\nJohn,\"A person with, comma\"";
        $expected = [
            ['name' => 'John', 'description' => 'A person with, comma'],
        ];

        $result = $this->parser->parse($input);

        $this->assertEquals($expected, $result);
    }

    /**
     * Тест для парсинга пустого CSV файла.
     */
    public function testParseEmptyCsv(): void
    {
        $input = '';

        $result = $this->parser->parse($input);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /**
     * Тест для парсинга CSV с только заголовками.
     */
    public function testParseCsvWithOnlyHeaders(): void
    {
        $input = 'name,age,city';

        $result = $this->parser->parse($input);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /**
     * Тест для парсинга CSV с несовпадающим количеством столбцов.
     */
    public function testParseCsvWithColumnMismatchThrowsException(): void
    {
        $input = "name,age\nJohn,30,Extra"; // Extra column

        $this->expectException(CsvParseException::class);
        $this->expectExceptionMessage('CSV: количество столбцов не совпадает с заголовками');

        $this->parser->parse($input);
    }

    /**
     * Тест для парсинга CSV с разными концами строк.
     */
    public function testParseCsvWithDifferentLineEndings(): void
    {
        $input    = "name,age\r\nJohn,30\r\nJane,25";
        $expected = [
            ['name' => 'John', 'age' => '30'],
            ['name' => 'Jane', 'age' => '25'],
        ];

        $result = $this->parser->parse($input);

        $this->assertEquals($expected, $result);
    }
}
