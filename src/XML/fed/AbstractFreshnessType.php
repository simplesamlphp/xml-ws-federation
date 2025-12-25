<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use DOMElement;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\BooleanValue;
use SimpleSAML\XMLSchema\Type\UnsignedIntValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

use function var_export;

/**
 * Class defining the FreshnessType element
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractFreshnessType extends AbstractFedElement
{
    use TypedTextContentTrait;
    use ExtendableAttributesTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    public const string TEXTCONTENT_TYPE = UnsignedIntValue::class;


    /**
     * AbstractFreshnessType constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\UnsignedIntValue $content
     * @param \SimpleSAML\XMLSchema\Type\BooleanValue|null $AllowCache
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        UnsignedIntValue $content,
        protected ?BooleanValue $AllowCache = null,
        array $namespacedAttributes = [],
    ) {
        $this->setContent($content);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\BooleanValue|null
     */
    public function getAllowCache(): ?BooleanValue
    {
        return $this->AllowCache;
    }


    /**
     * Create an instance of this object from its XML representation.
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        return new static(
            UnsignedIntValue::fromString($xml->textContent),
            self::getOptionalAttribute($xml, 'AllowCache', BooleanValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this IssuerNameType to an XML element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);
        $e->textContent = $this->getContent()->getValue();

        if ($this->getAllowCache() !== null) {
            $e->setAttribute('AllowCache', var_export($this->getAllowCache()->toBoolean(), true));
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
