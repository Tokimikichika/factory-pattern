<?php

namespace Tokimikichika\FactoryPattern\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Tokimikichika\FactoryPattern\Exception\CsvParseException;
use Tokimikichika\FactoryPattern\Exception\JsonParseException;
use Tokimikichika\FactoryPattern\Exception\UnsupportedParserTypeException;
use Tokimikichika\FactoryPattern\Exception\XmlParseException;
use Tokimikichika\FactoryPattern\Factory\ParserFactory;

/**
 * Тесты для интеграции парсеров.
 */
class ParserIntegrationTest extends TestCase
{
    /**
     * Тест для парсинга JSON.
     */
    public function testJsonParsingWorkflow(): void
    {
        $data = '{"users":[{"name":"John","age":30},{"name":"Jane","age":25}]}';

        $parser = ParserFactory::create('json');
        $result = $parser->parse($data);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('users', $result);
        $this->assertCount(2, $result['users']);
        $this->assertEquals('John', $result['users'][0]['name']);
    }

    /**
     * Тест для парсинга XML.
     */
    public function testXmlParsingWorkflow(): void
    {
        $data = '<users><user><name>John</name><age>30</age></user><user><name>Jane</name><age>25</age></user></users>';

        $parser = ParserFactory::create('xml');
        $result = $parser->parse($data);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('user', $result);
        $this->assertCount(2, $result['user']);
    }

    /**
     * Тест для парсинга CSV.
     */
    public function testCsvParsingWorkflow(): void
    {
        $data = "name,age,department\nJohn,30,IT\nJane,25,HR\nBob,35,Finance";

        $parser = ParserFactory::create('csv');
        $result = $parser->parse($data);

        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertEquals('John', $result[0]['name']);
        $this->assertEquals('IT', $result[0]['department']);
    }

    /**
     * Тест для обработки ошибок JSON.
     */
    public function testJsonErrorHandling(): void
    {
        $this->expectException(JsonParseException::class);
        ParserFactory::create('json')->parse('invalid json');
    }

    /**
     * Тест для обработки ошибок XML.
     */
    public function testXmlErrorHandling(): void
    {
        $this->expectException(XmlParseException::class);
        ParserFactory::create('xml')->parse('invalid xml');
    }

    /**
     * Тест для обработки ошибок CSV.
     */
    public function testCsvErrorHandling(): void
    {
        $this->expectException(CsvParseException::class);
        ParserFactory::create('csv')->parse("name,age\nJohn,30,extra");
    }

    /**
     * Тест для обработки неподдерживаемых типов парсеров.
     */
    public function testUnsupportedTypeErrorHandling(): void
    {
        $this->expectException(UnsupportedParserTypeException::class);
        ParserFactory::create('yaml');
    }

    /**
     * Тест для проверки паттерна Factory Method.
     */
    public function testFactoryMethodPattern(): void
    {
        $types = ['json', 'xml', 'csv'];

        foreach ($types as $type) {
            $parser = ParserFactory::create($type);

            $this->assertInstanceOf(\Tokimikichika\FactoryPattern\Interface\ParserInterface::class, $parser);

            $this->assertTrue(method_exists($parser, 'parse'));
            $this->assertTrue(is_callable([$parser, 'parse']));
        }
    }

    /**
     * Тест для парсинга JSON API ответа.
     */
    public function testJsonApiResponse(): void
    {
        $apiResponse = '{"status":"success","data":{"users":[{"id":1,"name":"John","email":"john@example.com"}]}}';
        $parser      = ParserFactory::create('json');
        $result      = $parser->parse($apiResponse);

        $this->assertEquals('success', $result['status']);
        $this->assertArrayHasKey('users', $result['data']);
    }

    /**
     * Тест для парсинга XML конфигурации.
     */
    public function testXmlConfiguration(): void
    {
        $config = '<config><database><host>localhost</host><port>3306</port></database></config>';
        $parser = ParserFactory::create('xml');
        $result = $parser->parse($config);

        $this->assertArrayHasKey('database', $result);
        $this->assertEquals('localhost', $result['database']['host']);
    }

    /**
     * Тест для парсинга CSV экспорта данных.
     */
    public function testCsvExportData(): void
    {
        $export = "id,name,email,created_at\n1,John,john@example.com,2023-01-01\n2,Jane,jane@example.com,2023-01-02";
        $parser = ParserFactory::create('csv');
        $result = $parser->parse($export);

        $this->assertCount(2, $result);
        $this->assertEquals('john@example.com', $result[0]['email']);
    }
}
