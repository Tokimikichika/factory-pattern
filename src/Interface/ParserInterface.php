<?php

namespace Tokimikichika\FactoryPattern\Interface;

// Интерфейс для парсеров данных
interface ParserInterface
{
    /**
     * Преобразовать входную строку данных в ассоциативный массив.
     *
     * @input string $input - входная строка данных
     * @return array - ассоциативный массив данных
     * @throws \InvalidArgumentException - если входная строка некорректна
     */
    public function parse(string $input): array;
}
