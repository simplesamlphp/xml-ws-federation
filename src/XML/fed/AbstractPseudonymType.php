<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use DOMElement;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * A PseudonymType
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractPseudonymType extends AbstractFedElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:any element */
    public const string XS_ANY_ELT_NAMESPACE = NS::ANY;

    /** The exclusions for the xs:any element */
    public const array XS_ANY_ELT_EXCLUSIONS = [
        ['http://docs.oasis-open.org/wsfed/federation/200706', 'PseudonymBasis'],
        ['http://docs.oasis-open.org/wsfed/federation/200706', 'RelativeTo'],
    ];


    /**
     * PseudonymType constructor.
     *
     * @param \SimpleSAML\WebServices\Federation\XML\fed\PseudonymBasis $pseudonymBasis
     * @param \SimpleSAML\WebServices\Federation\XML\fed\RelativeTo $relativeTo
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $children
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected PseudonymBasis $pseudonymBasis,
        protected RelativeTo $relativeTo,
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the pseudonymBasis-property
     *
     * @return \SimpleSAML\WebServices\Federation\XML\fed\PseudonymBasis
     */
    public function getPseudonymBasis(): PseudonymBasis
    {
        return $this->pseudonymBasis;
    }


    /**
     * Collect the value of the relativeTo-property
     *
     * @return \SimpleSAML\WebServices\Federation\XML\fed\RelativeTo
     */
    public function getRelativeTo(): RelativeTo
    {
        return $this->relativeTo;
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

        $pseudonymBasis = PseudonymBasis::getChildrenOfClass($xml);
        Assert::minCount($pseudonymBasis, 1, SchemaViolationException::class);
        Assert::maxCount($pseudonymBasis, 1, SchemaViolationException::class);

        $relativeTo = RelativeTo::getChildrenOfClass($xml);
        Assert::minCount($relativeTo, 1, SchemaViolationException::class);
        Assert::maxCount($relativeTo, 1, SchemaViolationException::class);

        return new static(
            $pseudonymBasis[0],
            $relativeTo[0],
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this PseudonymType to an XML element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        $this->getPseudonymBasis()->toXML($e);
        $this->getRelativeTo()->toXML($e);

        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
