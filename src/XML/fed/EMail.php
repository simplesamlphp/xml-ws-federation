<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use DOMElement;
use SimpleSAML\SAML2\Type\EmailAddressValue;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;

/**
 * An EMail element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class EMail extends AbstractAttributeExtensibleString
{
    /**
     * @param \SimpleSAML\SAML2\Type\EmailAddressValue $content
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    public function __construct(EmailAddressValue $content, array $namespacedAttributes = [])
    {
        parent::__construct($content, $namespacedAttributes);
    }


    /**
     * Create a class from XML
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(
            EmailAddressValue::fromString($xml->textContent),
            self::getAttributesNSFromXML($xml),
        );
    }
}
