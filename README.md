# Factory Pattern Library

Библиотека для демонстрации паттерна "Фабричный метод" с парсерами данных различных форматов (JSON, XML, CSV).

## Установка

```bash
# Клонирование репозитория
git clone <repository-url>
cd factory-pattern

# Установка зависимостей
composer install
```

## Быстрый старт

```php
<?php

require_once 'vendor/autoload.php';

use Tokimikichika\FactoryPattern\Factory\ParserFactory;

// Создание парсера через фабрику
$parser = ParserFactory::create('json');

// Парсинг данных
$data = '{"name":"John","age":30}';
$result = $parser->parse($data);

print_r($result);
// Array
// (
//     [name] => John
//     [age] => 30
// )
```

### ParserFactory

Основной класс для создания парсеров.

#### Методы

```php
// Создать парсер по типу
ParserFactory::create(string $type): ParserInterface

// Получить список поддерживаемых типов
ParserFactory::getSupportedTypes(): array

// Проверить поддержку типа
ParserFactory::isSupported(string $type): bool
```

#### Поддерживаемые типы

- `json` - JSON парсер
- `xml` - XML парсер  
- `csv` - CSV парсер

### ParserInterface

Интерфейс для всех парсеров.

```php
interface ParserInterface
{
    public function parse(string $input): array;
}
```

## 💡 Примеры использования

### JSON парсинг

```php
use Tokimikichika\FactoryPattern\Factory\ParserFactory;

$parser = ParserFactory::create('json');

// Простой объект
$data = '{"name":"Alice","age":25}';
$result = $parser->parse($data);

// Массив объектов
$data = '[{"id":1,"name":"John"},{"id":2,"name":"Jane"}]';
$result = $parser->parse($data);
```

### XML парсинг

```php
$parser = ParserFactory::create('xml');

// Простой XML
$data = '<user><name>Bob</name><age>30</age></user>';
$result = $parser->parse($data);

// XML с атрибутами
$data = '<user id="1"><name>Charlie</name></user>';
$result = $parser->parse($data);
```

### CSV парсинг

```php
$parser = ParserFactory::create('csv');

// Простой CSV
$data = "name,age,city\nJohn,30,New York\nJane,25,London";
$result = $parser->parse($data);

// CSV с кавычками
$data = 'name,description\nJohn,"A person with, comma"';
$result = $parser->parse($data);
```

### Проверка поддерживаемых типов

```php
// Получить все поддерживаемые типы
$types = ParserFactory::getSupportedTypes();
// ['json', 'xml', 'csv']

// Проверить поддержку конкретного типа
if (ParserFactory::isSupported('yaml')) {
    $parser = ParserFactory::create('yaml');
}
```

## 🧪 Тестирование и качество кода

### Запуск тестов

```bash
# Запуск всех тестов
composer test

# Запуск с покрытием кода
composer test-coverage

# Запуск конкретного теста
./vendor/bin/phpunit tests/Parser/JsonParserTest.php

# Запуск в verbose режиме
./vendor/bin/phpunit --verbose
```

### Проверка качества кода

```bash
# Проверка стиля кода (без изменений)
composer cs-check

# Автоматическое исправление стиля кода
composer cs-fix

# Проверка стандартов кодирования
composer cs-sniff

# Автоматическое исправление стандартов
composer cs-sniff-fix

# Полная проверка качества (стиль + стандарты + тесты)
composer quality
```


### Структура тестов

```
tests/
├── Exception/           # Тесты исключений
├── Parser/              # Тесты парсеров
├── Factory/             # Тесты фабрики
└── Integration/         # Интеграционные тесты
```

## Архитектура

### Паттерн "Фабричный метод"

Библиотека демонстрирует паттерн "Фабричный метод":

1. **Интерфейс** (`ParserInterface`) - определяет общий контракт
2. **Конкретные классы** (`JsonParser`, `XmlParser`, `CsvParser`) - реализуют интерфейс
3. **Фабрика** (`ParserFactory`) - создает нужный парсер по типу

### Структура проекта

```
src/
├── Exception/           # Исключения
│   ├── ParserException.php
│   ├── JsonParseException.php
│   ├── XmlParseException.php
│   ├── CsvParseException.php
│   └── UnsupportedParserTypeException.php
├── Interface/           # Интерфейсы
│   └── ParserInterface.php
├── Parser/              # Парсеры
│   ├── JsonParser.php
│   ├── XmlParser.php
│   └── CsvParser.php
└── Factory/             # Фабрика
    └── ParserFactory.php
```

### Преимущества архитектуры

- **Единая точка создания** - все парсеры создаются через фабрику
- **Легкое расширение** - добавление нового типа парсера требует только создания класса и обновления фабрики
- **Слабая связанность** - клиентский код не зависит от конкретных классов парсеров
- **Простота тестирования** - каждый компонент можно тестировать изолированно



## Требования

- PHP >= 8.0
- Composer
- PHPUnit ^10.0 (для разработки)

## Лицензия

MIT License

