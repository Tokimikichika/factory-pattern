<?php

namespace Tokimikichika\FactoryPattern\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Tokimikichika\FactoryPattern\Exception\UnsupportedParserTypeException;

/**
 * Тесты для исключения UnsupportedParserTypeException.
 */
class UnsupportedParserTypeExceptionTest extends TestCase
{
    /**
     * Тест для создания исключения с поддерживаемыми типами.
     */
    public function testCreateWithSupportedTypes(): void
    {
        $type           = 'yaml';
        $supportedTypes = ['json', 'xml', 'csv'];

        $exception = UnsupportedParserTypeException::create($type, $supportedTypes);

        $this->assertInstanceOf(UnsupportedParserTypeException::class, $exception);
        $this->assertEquals(
            "Неизвестный тип парсера: {$type}. Поддерживаемые типы: json, xml, csv",
            $exception->getMessage()
        );
    }

    /**
     * Тест для создания исключения с пустым списком поддерживаемых типов.
     */
    public function testCreateWithEmptySupportedTypes(): void
    {
        $type           = 'unknown';
        $supportedTypes = [];

        $exception = UnsupportedParserTypeException::create($type, $supportedTypes);

        $this->assertEquals(
            "Неизвестный тип парсера: {$type}. Поддерживаемые типы: ",
            $exception->getMessage()
        );
    }
}
