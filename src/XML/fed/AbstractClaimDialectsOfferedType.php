<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use DOMElement;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\WebServices\Federation\XML\fed\ClaimDialect;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\MissingElementException;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Class defining the ClaimDialectsOfferedType element
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractClaimDialectsOfferedType extends AbstractFedElement
{
    use ExtendableAttributesTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * AbstractClaimDialectsOfferedType constructor
     *
     * @param array<\SimpleSAML\WebServices\Federation\XML\fed\ClaimDialect> $claimDialect
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected array $claimDialect,
        array $namespacedAttributes = [],
    ) {
        Assert::notEmpty($claimDialect, SchemaViolationException::class);
        Assert::allIsInstanceOf($claimDialect, ClaimDialect::class);

        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return array<\SimpleSAML\WebServices\Federation\XML\fed\ClaimDialect>
     */
    public function getClaimDialect(): array
    {
        return $this->claimDialect;
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

        $claimDialect = ClaimDialect::getChildrenOfClass($xml);
        Assert::minCount(
            $claimDialect,
            1,
            'Missing <fed:ClaimDialect> in ClaimDialectsOffered.',
            MissingElementException::class,
        );

        return new static(
            $claimDialect,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this ClaimDialectsOfferedType to an XML element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        foreach ($this->getClaimDialect() as $claimDialect) {
            $claimDialect->toXML($e);
        }

        return $e;
    }
}
