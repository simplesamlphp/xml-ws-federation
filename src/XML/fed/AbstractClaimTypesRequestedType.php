<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use DOMElement;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\WebServices\Federation\XML\auth\ClaimType;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\MissingElementException;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Class defining the ClaimTypesRequestedType element
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractClaimTypesRequestedType extends AbstractFedElement
{
    use ExtendableAttributesTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractClaimTypesRequestedType constructor
     *
     * @param \SimpleSAML\WebServices\Federation\XML\auth\ClaimType[] $claimType
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    final public function __construct(
        protected array $claimType,
        array $namespacedAttributes = [],
    ) {
        Assert::notEmpty($claimType, SchemaViolationException::class);
        Assert::allIsInstanceOf($claimType, ClaimType::class);

        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\WebServices\Federation\XML\auth\ClaimType[]
     */
    public function getClaimType(): array
    {
        return $this->claimType;
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

        $claimType = ClaimType::getChildrenOfClass($xml);
        Assert::minCount(
            $claimType,
            1,
            MissingElementException::class,
        );

        return new static(
            $claimType,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this ClaimTypesRequestedType to an XML element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        foreach ($this->getClaimType() as $claimType) {
            $claimType->toXML($e);
        }

        return $e;
    }
}
