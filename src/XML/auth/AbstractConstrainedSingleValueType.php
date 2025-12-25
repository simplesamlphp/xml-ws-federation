<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\auth;

use DOMElement;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\TooManyElementsException;

use function array_pop;

/**
 * Class representing WS-authorization ConstrainedSingleValueType.
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractConstrainedSingleValueType extends AbstractAuthElement
{
    /**
     * AbstractConstrainedSingleValueType constructor.
     *
     * @param \SimpleSAML\WebServices\Federation\XML\auth\Value $value
     * @param \SimpleSAML\WebServices\Federation\XML\auth\StructuredValue $structuredValue
     */
    final public function __construct(
        protected ?Value $value = null,
        protected ?StructuredValue $structuredValue = null,
    ) {
        Assert::oneOf(
            null,
            [$structuredValue, $value],
            'Can only have one of StructuredValue/Value',
        );
    }


    /**
     * Get the value of the $structuredValue property.
     *
     * @return \SimpleSAML\WebServices\Federation\XML\auth\StructuredValue|null
     */
    public function getStructuredValue(): ?StructuredValue
    {
        return $this->structuredValue;
    }


    /**
     * Get the value of the $value property.
     *
     * @return \SimpleSAML\WebServices\Federation\XML\auth\Value|null
     */
    public function getValue(): ?Value
    {
        return $this->value;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     */
    public function isEmptyElement(): bool
    {
        return empty($this->value) && empty($this->structuredValue);
    }


    /**
     * Convert XML into a class instance
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $structuredValue = StructuredValue::getChildrenOfClass($xml);
        Assert::maxCount($structuredValue, 1, TooManyElementsException::class);

        $value = Value::getChildrenOfClass($xml);
        Assert::maxCount($value, 1, TooManyElementsException::class);

        return new static(
            array_pop($value),
            array_pop($structuredValue),
        );
    }


    /**
     * Convert this element to XML.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        $this->getStructuredValue()?->toXML($e);
        $this->getValue()?->toXML($e);

        return $e;
    }
}
