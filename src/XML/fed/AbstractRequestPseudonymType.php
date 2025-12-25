<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use DOMElement;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Type\BooleanValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

use function var_export;

/**
 * Class defining the RequestPseudonymType element
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractRequestPseudonymType extends AbstractFedElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:any element */
    public const string XS_ANY_ELT_NAMESPACE = NS::OTHER;


    /**
     * AbstractRequestPseudonymType constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\BooleanValue|null $SingleUse
     * @param \SimpleSAML\XMLSchema\Type\BooleanValue|null $Lookup
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $children
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected ?BooleanValue $SingleUse = null,
        protected ?BooleanValue $Lookup = null,
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\BooleanValue|null
     */
    public function getSingleUse(): ?BooleanValue
    {
        return $this->SingleUse;
    }


    /**
     * @return \SimpleSAML\XMLSchema\Type\BooleanValue|null
     */
    public function getLookup(): ?BooleanValue
    {
        return $this->Lookup;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getSingleUse())
            && empty($this->getLookup())
            && empty($this->getElements())
            && empty($this->getAttributesNS());
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
            self::getOptionalAttribute($xml, 'SingleUse', BooleanValue::class, null),
            self::getOptionalAttribute($xml, 'Lookup', BooleanValue::class, null),
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this AbstractRequestPseudonymType to an XML element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $singleUse = $this->getSingleUse();
        if ($singleUse !== null) {
            $e->setAttribute('SingleUse', var_export($singleUse->toBoolean(), true));
        }

        $lookup = $this->getLookup();
        if ($lookup !== null) {
            $e->setAttribute('Lookup', var_export($lookup->toBoolean(), true));
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
