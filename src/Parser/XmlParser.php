<?php

namespace Tokimikichika\FactoryPattern\Parser;

use Tokimikichika\FactoryPattern\Exception\XmlParseException;
use Tokimikichika\FactoryPattern\Interface\ParserInterface;

// Парсер XML данных
class XmlParser implements ParserInterface
{
    /**
     * Преобразовать входную строку XML в ассоциативный массив.
     *
     * @throws XmlParseException
     */
    public function parse(string $input): array
    {
        $previous = libxml_disable_entity_loader(true);
        libxml_use_internal_errors(true);
        $element = simplexml_load_string($input, 'SimpleXMLElement', LIBXML_NONET | LIBXML_NOCDATA);
        libxml_disable_entity_loader($previous);

        if ($element === false) {
            $error = libxml_get_last_error();
            libxml_clear_errors();

            throw $error ?
                XmlParseException::fromLibXmlError($error->message) :
                XmlParseException::unknownError();
        }

        $json = json_encode($element);
        $data = json_decode((string) $json, true);

        return \is_array($data) ? $data : [];
    }
}
