<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use DOMElement;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\StringValue;

/**
 * A DisplayName element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class DisplayName extends AbstractAttributeExtensibleString
{
    /**
     * Create a class from XML
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(
            StringValue::fromString($xml->textContent),
            self::getAttributesNSFromXML($xml),
        );
    }
}
