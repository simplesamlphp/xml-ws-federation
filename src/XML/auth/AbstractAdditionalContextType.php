<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\auth;

use DOMElement;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\WebServices\Federation\XML\auth\ContextItem;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Class defining the AdditionalContextType element
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractAdditionalContextType extends AbstractAuthElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;


    /** The namespace-attribute for the xs:anyAttribute */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:any */
    public const string XS_ANY_ELT_NAMESPACE = NS::OTHER;


    /**
     * AbstractAdditionalContextType constructor
     *
     * @param \SimpleSAML\WebServices\Federation\XML\auth\ContextItem[] $contextItem
     * @param list<\SimpleSAML\XML\SerializableElementInterface> $children
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected array $contextItem = [],
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Get the value of the $contextItem property.
     *
     * @return \SimpleSAML\WebServices\Federation\XML\auth\ContextItem[]
     */
    public function getContextItem(): array
    {
        return $this->contextItem;
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

        $contextItem = ContextItem::getChildrenOfClass($xml);
        $children = self::getChildElementsFromXML($xml);

        return new static(
            $contextItem,
            $children,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this AdditionalContext to an XML element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        foreach ($this->getContextItem() as $ctx) {
            $ctx->toXML($e);
        }

        foreach ($this->getElements() as $elt) {
            $elt->toXML($e);
        }

        return $e;
    }
}
