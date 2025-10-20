<?php

namespace Tokimikichika\FactoryPattern\Tests\Parser;

use PHPUnit\Framework\TestCase;
use Tokimikichika\FactoryPattern\Exception\XmlParseException;
use Tokimikichika\FactoryPattern\Parser\XmlParser;

/**
 * Тесты для парсера XML.
 */
class XmlParserTest extends TestCase
{
    private XmlParser $parser;

    protected function setUp(): void
    {
        $this->parser = new XmlParser();
    }

    /**
     * Тест для парсинга корректного XML объекта.
     */
    public function testParseValidXml(): void
    {
        $input = '<user><name>John</name><age>30</age></user>';

        $result = $this->parser->parse($input);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('age', $result);
        $this->assertEquals('John', $result['name']);
        $this->assertEquals('30', $result['age']);
    }

    /**
     * Тест для парсинга XML с атрибутами.
     */
    public function testParseXmlWithAttributes(): void
    {
        $input = '<user id="1"><name>John</name></user>';

        $result = $this->parser->parse($input);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('@attributes', $result);
        $this->assertEquals('1', $result['@attributes']['id']);
    }

    /**
     * Тест для парсинга пустого XML.
     */
    public function testParseEmptyXml(): void
    {
        $input = '<root></root>';

        $result = $this->parser->parse($input);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /**
     * Тест для парсинга некорректного XML.
     */
    public function testParseInvalidXmlThrowsException(): void
    {
        $input = '<user><name>John</name>';

        $this->expectException(XmlParseException::class);
        $this->expectExceptionMessage('Некорректный XML:');

        $this->parser->parse($input);
    }

    /**
     * Тест для парсинга некорректного XML.
     */
    public function testParseMalformedXmlThrowsException(): void
    {
        $input = 'not xml at all';

        $this->expectException(XmlParseException::class);
        $this->expectExceptionMessage('Некорректный XML:');

        $this->parser->parse($input);
    }
}
