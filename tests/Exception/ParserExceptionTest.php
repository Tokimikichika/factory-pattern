<?php

namespace Tokimikichika\FactoryPattern\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Tokimikichika\FactoryPattern\Exception\ParserException;

/**
 * Тесты для исключения ParserException.
 */
class ParserExceptionTest extends TestCase
{
    /**
     * Тест для создания исключения с сообщением
     */
    public function testCanCreateExceptionWithMessage(): void
    {
        $message   = 'Test error message';
        $exception = new ParserException($message);

        $this->assertEquals($message, $exception->getMessage());
        $this->assertEquals(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    /**
     * Тест для создания исключения с сообщением и кодом
     */
    public function testCanCreateExceptionWithMessageAndCode(): void
    {
        $message   = 'Test error message';
        $code      = 123;
        $exception = new ParserException($message, $code);

        $this->assertEquals($message, $exception->getMessage());
        $this->assertEquals($code, $exception->getCode());
    }

    /**
     * Тест для создания исключения с предыдущим исключением
     */
    public function testCanCreateExceptionWithPreviousException(): void
    {
        $previous  = new \Exception('Previous error');
        $exception = new ParserException('Test error', 0, $previous);

        $this->assertEquals('Test error', $exception->getMessage());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
