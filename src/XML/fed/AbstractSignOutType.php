<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use DOMElement;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\WebServices\Federation\Constants as C;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\WebServices\Security\XML\wsu\IDTrait;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\ExtendableElementTrait;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\MissingElementException;
use SimpleSAML\XMLSchema\Exception\TooManyElementsException;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * A SignOutType
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractSignOutType extends AbstractFedElement
{
    use ExtendableAttributesTrait;
    use ExtendableElementTrait;
    use IDTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    /** The namespace-attribute for the xs:any element */
    public const string XS_ANY_ELT_NAMESPACE = NS::ANY;

    /** The exclusions for the xs:any element */
    public const array XS_ANY_ELT_EXCLUSIONS = [
        ['http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd', 'Id'],
        ['http://docs.oasis-open.org/wsfed/federation/200706', 'Realm'],
        ['http://docs.oasis-open.org/wsfed/federation/200706', 'SignOutBasis'],
    ];


    /**
     * SignOutType constructor.
     *
     * @param \SimpleSAML\WebServices\Federation\XML\fed\SignOutBasis $signOutBasis
     * @param \SimpleSAML\WebServices\Federation\XML\fed\Realm|null $realm
     * @param \SimpleSAML\WebServices\Security\Type\IDValue|null $Id
     * @param array<\SimpleSAML\XML\SerializableElementInterface> $children
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected SignOutBasis $signOutBasis,
        protected ?Realm $realm = null,
        ?IDValue $Id = null,
        array $children = [],
        array $namespacedAttributes = [],
    ) {
        $this->setId($Id);
        $this->setElements($children);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Collect the value of the signOutBasis-property
     *
     * @return \SimpleSAML\WebServices\Federation\XML\fed\SignOutBasis
     */
    public function getSignOutBasis(): SignOutBasis
    {
        return $this->signOutBasis;
    }


    /**
     * Collect the value of the realm-property
     *
     * @return \SimpleSAML\WebServices\Federation\XML\fed\Realm|null
     */
    public function getRealm(): ?Realm
    {
        return $this->realm;
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

        $Id = null;
        if ($xml->hasAttributeNS(C::NS_SEC_UTIL, 'Id')) {
            $Id = IDValue::fromString($xml->getAttributeNS(C::NS_SEC_UTIL, 'Id'));
        }

        $signOutBasis = SignOutBasis::getChildrenOfClass($xml);
        Assert::minCount($signOutBasis, 1, MissingElementException::class);
        Assert::maxCount($signOutBasis, 1, TooManyElementsException::class);

        $realm = Realm::getChildrenOfClass($xml);
        Assert::maxCount($realm, 1, TooManyElementsException::class);

        return new static(
            $signOutBasis[0],
            array_pop($realm),
            $Id,
            self::getChildElementsFromXML($xml),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this SignOutType to an XML element.
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        $this->getId()?->toAttribute()->toXML($e);

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        $this->getRealm()?->toXML($e);
        $this->getSignOutBasis()->toXML($e);

        foreach ($this->getElements() as $child) {
            if (!$child->isEmptyElement()) {
                $child->toXML($e);
            }
        }

        return $e;
    }
}
