<?php

require_once 'vendor/autoload.php';

use Tokimikichika\FactoryPattern\Factory\ParserFactory;

echo "=== Фабрика парсеров: JSON / XML / CSV ===\n\n";

$samples = [
    'json' => '{"name":"Alice","age":30}',
    'xml'  => '<user><name>Alice</name><age>30</age></user>',
    'csv'  => "name,age\nAlice,30\nBob,25",
];

foreach ($samples as $type => $input) {
    try {
        $parser = ParserFactory::create($type);
        $data   = $parser->parse($input);
        echo strtoupper($type) . ': ' . json_encode($data, JSON_UNESCAPED_UNICODE) . "\n";
    } catch (InvalidArgumentException $e) {
        echo "Ошибка для {$type}: {$e->getMessage()}\n";
    }
}

echo "\n=== Преимущества ===\n";
echo "1. Централизованное создание парсеров\n";
echo "2. Легко добавить новый формат (YAML, INI)\n";
echo "3. Клиентский код не зависит от конкретных классов\n";
