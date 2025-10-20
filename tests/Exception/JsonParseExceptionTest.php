<?php

namespace Tokimikichika\FactoryPattern\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Tokimikichika\FactoryPattern\Exception\JsonParseException;

/**
 * Тесты для исключения JsonParseException.
 */
class JsonParseExceptionTest extends TestCase
{
    /**
     * Тест для создания исключения с ошибкой парсинга JSON.
     */
    public function testFromJsonError(): void
    {
        $jsonError = 'Syntax error';
        $exception = JsonParseException::fromJsonError($jsonError);

        $this->assertInstanceOf(JsonParseException::class, $exception);
        $this->assertEquals("Некорректный JSON: {$jsonError}", $exception->getMessage());
    }

    /**
     * Тест для создания исключения с некорректным форматом данных.
     */
    public function testInvalidFormat(): void
    {
        $exception = JsonParseException::invalidFormat();

        $this->assertInstanceOf(JsonParseException::class, $exception);
        $this->assertEquals('JSON должен представлять объект или массив', $exception->getMessage());
    }
}
