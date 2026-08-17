<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\auth;

use Dom;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\StringValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Class representing WS-authorization DisplayValueType.
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractDisplayValueType extends AbstractAuthElement
{
    use ExtendableAttributesTrait;
    use TypedTextContentTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    public const string TEXTCONTENT_TYPE = StringValue::class;


    /**
     * AbstractDisplayValueType constructor.
     *
     * @param \SimpleSAML\XMLSchema\Type\StringValue $value The value string.
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(StringValue $value, array $namespacedAttributes = [])
    {
        $this->setContent($value);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Convert XML into a class instance
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(Dom\Element $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        /** @var string $textContent */
        $textContent = $xml->textContent;
        Assert::notNull($textContent);

        return new static(StringValue::fromString($textContent), self::getAttributesNSFromXML($xml));
    }


    /**
     * Convert this element to XML.
     */
    public function toXML(?Dom\Element $parent = null): Dom\Element
    {
        $e = $this->instantiateParentElement($parent);
        $e->textContent = $this->getContent()->getValue();

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
