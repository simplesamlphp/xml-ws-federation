<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\auth;

use DOMElement;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\MissingElementException;
use SimpleSAML\XMLSchema\Exception\TooManyElementsException;

/**
 * Class defining the ValueInRangeType element
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractValueInRangeType extends AbstractAuthElement
{
    /**
     * AbstractValueInRangeType constructor
     *
     * @param \SimpleSAML\WebServices\Federation\XML\auth\ValueUpperBound $valueUpperBound
     * @param \SimpleSAML\WebServices\Federation\XML\auth\ValueLowerBound $valueLowerBound
     */
    final public function __construct(
        protected ValueUpperBound $valueUpperBound,
        protected ValueLowerBound $valueLowerBound,
    ) {
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

        $valueUpperBound = ValueUpperBound::getChildrenOfClass($xml);
        Assert::minCount($valueUpperBound, 1, MissingElementException::class);
        Assert::maxCount($valueUpperBound, 1, TooManyElementsException::class);

        $valueLowerBound = ValueLowerBound::getChildrenOfClass($xml);
        Assert::minCount($valueLowerBound, 1, MissingElementException::class);
        Assert::maxCount($valueLowerBound, 1, TooManyElementsException::class);

        return new static(
            $valueUpperBound[0],
            $valueLowerBound[0],
        );
    }


    /**
     * Get the value of the $valueUpperBound property.
     *
     * @return \SimpleSAML\WebServices\Federation\XML\auth\ValueUpperBound
     */
    public function getValueUpperBound(): ValueUpperBound
    {
        return $this->valueUpperBound;
    }


    /**
     * Get the value of the $valueLowerBound property.
     *
     * @return \SimpleSAML\WebServices\Federation\XML\auth\ValueLowerBound
     */
    public function getValueLowerBound(): ValueLowerBound
    {
        return $this->valueLowerBound;
    }


    /**
     * Add this ValueInRangeType to an XML element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $this->getValueUpperBound()->toXML($e);
        $this->getValueLowerBound()->toXML($e);

        return $e;
    }
}
