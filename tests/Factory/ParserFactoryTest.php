<?php

namespace Tokimikichika\FactoryPattern\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Tokimikichika\FactoryPattern\Exception\UnsupportedParserTypeException;
use Tokimikichika\FactoryPattern\Factory\ParserFactory;
use Tokimikichika\FactoryPattern\Interface\ParserInterface;
use Tokimikichika\FactoryPattern\Parser\CsvParser;
use Tokimikichika\FactoryPattern\Parser\JsonParser;
use Tokimikichika\FactoryPattern\Parser\XmlParser;

/**
 * Тесты для фабрики парсеров.
 */
class ParserFactoryTest extends TestCase
{
    /**
     * Тест для создания парсера JSON.
     */
    public function testCreateJsonParser(): void
    {
        $parser = ParserFactory::create('json');

        $this->assertInstanceOf(JsonParser::class, $parser);
        $this->assertInstanceOf(ParserInterface::class, $parser);
    }

    /**
     * Тест для создания парсера XML.
     */
    public function testCreateXmlParser(): void
    {
        $parser = ParserFactory::create('xml');

        $this->assertInstanceOf(XmlParser::class, $parser);
        $this->assertInstanceOf(ParserInterface::class, $parser);
    }

    /**
     * Тест для создания парсера CSV.
     */
    public function testCreateCsvParser(): void
    {
        $parser = ParserFactory::create('csv');

        $this->assertInstanceOf(CsvParser::class, $parser);
        $this->assertInstanceOf(ParserInterface::class, $parser);
    }

    /**
     * Тест для создания парсера в случае неверного регистра.
     */
    public function testCreateParserCaseInsensitive(): void
    {
        $jsonParser = ParserFactory::create('JSON');
        $xmlParser  = ParserFactory::create('XML');
        $csvParser  = ParserFactory::create('CSV');

        $this->assertInstanceOf(JsonParser::class, $jsonParser);
        $this->assertInstanceOf(XmlParser::class, $xmlParser);
        $this->assertInstanceOf(CsvParser::class, $csvParser);
    }

    /**
     * Тест для создания парсера в случае неверного типа.
     */
    public function testCreateUnsupportedParserThrowsException(): void
    {
        $this->expectException(UnsupportedParserTypeException::class);
        $this->expectExceptionMessage('Неизвестный тип парсера: yaml. Поддерживаемые типы: json, xml, csv');

        ParserFactory::create('yaml');
    }

    /**
     * Тест для получения списка поддерживаемых типов парсеров.
     */
    public function testGetSupportedTypes(): void
    {
        $types = ParserFactory::getSupportedTypes();

        $this->assertIsArray($types);
        $this->assertCount(3, $types);
        $this->assertContains('json', $types);
        $this->assertContains('xml', $types);
        $this->assertContains('csv', $types);
    }

    /**
     * Тест для проверки поддержки верных типов парсеров.
     */
    public function testIsSupportedWithValidTypes(): void
    {
        $this->assertTrue(ParserFactory::isSupported('json'));
        $this->assertTrue(ParserFactory::isSupported('xml'));
        $this->assertTrue(ParserFactory::isSupported('csv'));
        $this->assertTrue(ParserFactory::isSupported('JSON'));
        $this->assertTrue(ParserFactory::isSupported('XML'));
        $this->assertTrue(ParserFactory::isSupported('CSV'));
    }

    /**
     * Тест для проверки поддержки неверных типов парсеров.
     */
    public function testIsSupportedWithInvalidTypes(): void
    {
        $this->assertFalse(ParserFactory::isSupported('yaml'));
        $this->assertFalse(ParserFactory::isSupported('ini'));
        $this->assertFalse(ParserFactory::isSupported(''));
        $this->assertFalse(ParserFactory::isSupported('json '));
    }

    /**
     * Тест для создания всех поддерживаемых типов парсеров.
     */
    public function testCreateAllSupportedTypes(): void
    {
        $supportedTypes = ParserFactory::getSupportedTypes();

        foreach ($supportedTypes as $type) {
            $parser = ParserFactory::create($type);
            $this->assertInstanceOf(ParserInterface::class, $parser);
        }
    }
}
