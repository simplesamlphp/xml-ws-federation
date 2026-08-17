<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use Dom;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\Base64BinaryValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * An AbstractReferenceDigestType element
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractReferenceDigestType extends AbstractFedElement
{
    use ExtendableAttributesTrait;
    use TypedTextContentTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    public const string TEXTCONTENT_TYPE = Base64BinaryValue::class;


    /**
     * @param \SimpleSAML\XMLSchema\Type\Base64BinaryValue $content
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    final public function __construct(Base64BinaryValue $content, array $namespacedAttributes)
    {
        $this->setContent($content);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Create a class from XML
     */
    public static function fromXML(Dom\Element $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        /** @var string $textContent */
        $textContent = $xml->textContent;
        Assert::notNull($textContent);

        return new static(
            Base64BinaryValue::fromString($textContent),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Create XML from this class
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
