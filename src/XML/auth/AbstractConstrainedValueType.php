<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\auth;

use DOMElement;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\MissingElementException;
use SimpleSAML\XMLSchema\Exception\TooManyElementsException;
use SimpleSAML\XMLSchema\Type\BooleanValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

use function array_merge;
use function var_export;

/**
 * Class defining the ConstrainedValueType element
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractConstrainedValueType extends AbstractAuthElement
{
    use ExtendableElementTrait;


    /** The namespace-attribute for the xs:any element */
    public const string XS_ANY_ELT_NAMESPACE = NS::OTHER;


    /**
     * AbstractConstrainedValueType constructor
     *
     * @param \SimpleSAML\WebServices\Federation\XML\auth\ConstrainedValueInterface $value
     * @param \SimpleSAML\XML\SerializableElementInterface[] $children
     * @param \SimpleSAML\XMLSchema\Type\BooleanValue|null $assertConstraint
     */
    final public function __construct(
        protected ConstrainedValueInterface $value,
        array $children = [],
        protected ?BooleanValue $assertConstraint = null,
    ) {
        $this->setElements($children);
    }


    /**
     * Get the value of the $value property.
     *
     * @return \SimpleSAML\WebServices\Federation\XML\auth\ConstrainedValueInterface
     */
    public function getValue(): ConstrainedValueInterface
    {
        return $this->value;
    }


    /**
     * Get the value of the assertConstraint property.
     *
     * @return \SimpleSAML\XMLSchema\Type\BooleanValue|null
     */
    public function getAssertConstraint(): ?BooleanValue
    {
        return $this->assertConstraint;
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

        $valueLessThan = ValueLessThan::getChildrenOfClass($xml);
        $valueLessThanOrEqual = ValueLessThanOrEqual::getChildrenOfClass($xml);
        $valueGreaterThan = ValueGreaterThan::getChildrenOfClass($xml);
        $valueGreaterThanOrEqual = ValueGreaterThanOrEqual::getChildrenOfClass($xml);
        $valueInRangen = ValueInRangen::getChildrenOfClass($xml);
        $valueOneOf = ValueOneOf::getChildrenOfClass($xml);

        $value = array_merge(
            $valueLessThan,
            $valueLessThanOrEqual,
            $valueGreaterThan,
            $valueGreaterThanOrEqual,
            $valueInRangen,
            $valueOneOf,
        );
        Assert::minCount($value, 1, MissingElementException::class);
        Assert::maxCount($value, 1, TooManyElementsException::class);

        return new static(
            $value[0],
            self::getChildElementsFromXML($xml),
            self::getOptionalAttribute($xml, 'AssertConstraint', BooleanValue::class, null),
        );
    }


    /**
     * Add this ConstrainedValueType to an XML element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        if ($this->getAssertConstraint() !== null) {
            $e->setAttribute('AssertConstraint', var_export($this->getAssertConstraint()->toBoolean(), true));
        }

        $this->getValue()->toXML($e);

        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
