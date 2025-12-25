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

use function array_pop;

/**
 * Class defining the ClientPseudonymType element
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractClientPseudonymType extends AbstractFedElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:any element */
    public const string XS_ANY_ELT_NAMESPACE = NS::OTHER;


    /**
     * AbstractClientPseudonymType constructor
     *
     * @param \SimpleSAML\WebServices\Federation\XML\fed\PPID|null $ppid
     * @param \SimpleSAML\WebServices\Federation\XML\fed\DisplayName|null $displayName
     * @param \SimpleSAML\WebServices\Federation\XML\fed\EMail|null $email
     * @param \SimpleSAML\XML\SerializableElementInterface[] $children
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    final public function __construct(
        protected ?PPID $ppid = null,
        protected ?DisplayName $displayName = null,
        protected ?EMail $email = null,
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * @return \SimpleSAML\WebServices\Federation\XML\fed\PPID|null
     */
    public function getPPID(): ?PPID
    {
        return $this->ppid;
    }


    /**
     * @return \SimpleSAML\WebServices\Federation\XML\fed\DisplayName|null
     */
    public function getDisplayName(): ?DisplayName
    {
        return $this->displayName;
    }


    /**
     * @return \SimpleSAML\WebServices\Federation\XML\fed\EMail|null
     */
    public function getEMail(): ?EMail
    {
        return $this->email;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     */
    public function isEmptyElement(): bool
    {
        return empty($this->getPPID())
            && empty($this->getDisplayName())
            && empty($this->getEMail())
            && empty($this->getAttributesNS())
            && empty($this->getElements());
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

        $ppid = PPID::getChildrenOfClass($xml);
        Assert::maxCount($ppid, 1, SchemaViolationException::class);

        $displayName = DisplayName::getChildrenOfClass($xml);
        Assert::maxCount($displayName, 1, SchemaViolationException::class);

        $email = EMail::getChildrenOfClass($xml);
        Assert::maxCount($email, 1, SchemaViolationException::class);

        return new static(
            array_pop($ppid),
            array_pop($displayName),
            array_pop($email),
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this ClientPseudonymType to an XML element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $this->getPPID()?->toXML($e);
        $this->getDisplayName()?->toXML($e);
        $this->getEMail()?->toXML($e);

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
