<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use DOMElement;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\WebServices\Federation\XML\fed\IssuerName;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\MissingElementException;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * Class defining the LogicalServiceNamesOfferedType element
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractLogicalServiceNamesOfferedType extends AbstractFedElement
{
    use ExtendableAttributesTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;


    /**
     * LogicalServiceNamesOfferedType constructor
     *
     * @param array<\SimpleSAML\WebServices\Federation\XML\fed\IssuerName> $issuerName
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected array $issuerName,
        array $namespacedAttributes = [],
    ) {
        Assert::minCount($issuerName, 1, MissingElementException::class);
        Assert::allIsInstanceOf($issuerName, IssuerName::class);

        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return array<\SimpleSAML\WebServices\Federation\XML\fed\IssuerName>
     */
    public function getIssuerName(): array
    {
        return $this->issuerName;
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

        $issuerName = IssuerName::getChildrenOfClass($xml);
        Assert::minCount(
            $issuerName,
            1,
            'Missing <fed:IssuerName> in LogicalServiceNamesOfferedType.',
            MissingElementException::class,
        );

        return new static(
            $issuerName,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this LogicalServiceNamesOfferedType to an XML element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        foreach ($this->getIssuerName() as $issuerName) {
            $issuerName->toXML($e);
        }

        return $e;
    }
}
