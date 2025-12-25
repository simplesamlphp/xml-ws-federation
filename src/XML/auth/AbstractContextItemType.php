<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\auth;

use DOMElement;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XML\SerializableElementInterface;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Exception\TooManyElementsException;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

use function array_pop;

/**
 * Class defining the ContextItemType element
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractContextItemType extends AbstractAuthElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;


    /** The namespace-attribute for the xs:anyAttribute */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:any */
    public const string XS_ANY_ELT_NAMESPACE = NS::OTHER;


    /**
     * AbstractContextItemType constructor
     *
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue $Name
     * @param \SimpleSAML\XMLSchema\Type\AnyURIValue|null $Scope
     * @param \SimpleSAML\WebServices\Federation\XML\auth\Value|null $value
     * @param \SimpleSAML\XML\SerializableElementInterface|null $child
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected AnyURIValue $Name,
        protected ?AnyURIValue $Scope = null,
        protected ?Value $value = null,
        ?SerializableElementInterface $child = null,
        array $namespacedAttributes = [],
    ) {
        // One of both must exist, they can't be both null
        Assert::inArray(null, [$value, $child], SchemaViolationException::class);
        Assert::notSame($value, $child, SchemaViolationException::class);

        if ($child !== null) {
            $this->setElements([$child]);
        }
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Get the value of the $value property.
     *
     * @return \SimpleSAML\WebServices\Federation\XML\auth\Value
     */
    public function getValue(): ?Value
    {
        return $this->value;
    }


    /**
     * Get the value of the Name property.
     *
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue
     */
    public function getName(): AnyURIValue
    {
        return $this->Name;
    }


    /**
     * Get the value of the Scope property.
     *
     * @return \SimpleSAML\XMLSchema\Type\AnyURIValue|null
     */
    public function getScope(): ?AnyURIValue
    {
        return $this->Scope;
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

        $value = Value::getChildrenOfClass($xml);
        Assert::maxCount($value, 1, TooManyElementsException::class);

        $children = self::getChildElementsFromXML($xml);
        Assert::maxCount($children, 1, TooManyElementsException::class);

        return new static(
            self::getAttribute($xml, 'Name', AnyURIValue::class),
            self::getOptionalAttribute($xml, 'Scope', AnyURIValue::class, null),
            array_pop($value),
            array_pop($children),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this ContextItemType to an XML element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        $e->setAttribute('Name', $this->getName()->getValue());
        if ($this->getScope() !== null) {
            $e->setAttribute('Scope', $this->getScope()->getValue());
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        $this->getValue()?->toXML($e);

        foreach ($this->getElements() as $elt) {
            $elt->toXML($e);
        }

        return $e;
    }
}
