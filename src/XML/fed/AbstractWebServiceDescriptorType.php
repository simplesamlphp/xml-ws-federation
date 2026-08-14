<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use DOMElement;
use SimpleSAML\SAML2\Type\SAMLAnyURIListValue;
use SimpleSAML\SAML2\Type\SAMLAnyURIValue;
use SimpleSAML\SAML2\Type\SAMLDateTimeValue;
use SimpleSAML\SAML2\Type\SAMLStringValue;
use SimpleSAML\SAML2\XML\md\AbstractRoleDescriptor;
use SimpleSAML\SAML2\XML\md\Extensions;
use SimpleSAML\SAML2\XML\md\Organization;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XMLSchema\Constants as C;
use SimpleSAML\XMLSchema\Type\DurationValue;
use SimpleSAML\XMLSchema\Type\IDValue;
use SimpleSAML\XMLSchema\Type\QNameValue;

/**
 * An WebServiceDescriptorType
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractWebServiceDescriptorType extends AbstractRoleDescriptor
{
    /**
     * The element is md:RoleDescriptor, but its content model lives in the WS-Federation schema — that is
     * what the xsi:type points at. Validating against the inherited metadata schema alone can never resolve
     * it, because md:RoleDescriptorType is abstract. ws-federation.xsd imports the metadata namespace.
     */
    public const string SCHEMA = 'resources/schemas/ws-federation.xsd';

    /**
     * The exclusions for the xs:anyAttribute element
     *
     * xsi:type is modelled by AbstractRoleDescriptor as $type and returned by getXsiType(); without this
     * exclusion it would also be swept into the extendable-attributes bucket and written a second time.
     */
    public const array XS_ANY_ATTR_EXCLUSIONS = [
        [C::NS_XSI, 'type'],
    ];


    /**
     * WebServiceDescriptorType constructor.
     *
     * @param \SimpleSAML\XMLSchema\Type\QNameValue $type The xsi-type of the element
     * @param \SimpleSAML\SAML2\Type\SAMLAnyURIListValue $protocolSupportEnumeration
     *   A set of URI specifying the protocols supported.
     * @param \SimpleSAML\XMLSchema\Type\IDValue|null $ID The ID for this document. Defaults to null.
     * @param \SimpleSAML\SAML2\Type\SAMLDateTimeValue|null $validUntil
     *   Unix time of validity for this document. Defaults to null.
     * @param \SimpleSAML\XMLSchema\Type\DurationValue|null $cacheDuration
     *   Maximum time this document can be cached. Defaults to null.
     * @param \SimpleSAML\SAML2\XML\md\Extensions|null $extensions An array of extensions. Defaults to an empty array.
     * @param \SimpleSAML\SAML2\Type\SAMLAnyURIValue|null $errorURL
     *   An URI where to redirect users for support. Defaults to null.
     * @param \SimpleSAML\SAML2\XML\md\KeyDescriptor[] $keyDescriptors An array of KeyDescriptor elements.
     *   Defaults to an empty array.
     * @param \SimpleSAML\SAML2\XML\md\Organization|null $organization
     *   The organization running this entity. Defaults to null.
     * @param \SimpleSAML\SAML2\XML\md\ContactPerson[] $contacts An array of contacts for this entity.
     *   Defaults to an empty array.
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     * @param \SimpleSAML\WebServices\Federation\XML\fed\LogicalServiceNamesOffered|null $logicalServiceNamesOffered
     * @param \SimpleSAML\WebServices\Federation\XML\fed\TokenTypesOffered|null $tokenTypesOffered
     * @param \SimpleSAML\WebServices\Federation\XML\fed\ClaimDialectsOffered|null $claimDialectsOffered
     * @param \SimpleSAML\WebServices\Federation\XML\fed\ClaimTypesOffered|null $claimTypesOffered
     * @param \SimpleSAML\WebServices\Federation\XML\fed\ClaimTypesRequested|null $claimTypesRequested
     * @param \SimpleSAML\WebServices\Federation\XML\fed\AutomaticPseudonyms|null $automaticPseudonyms
     * @param \SimpleSAML\WebServices\Federation\XML\fed\TargetScopes|null $targetScopes
     * @param \SimpleSAML\SAML2\Type\SAMLStringValue|null $serviceDisplayName
     * @param \SimpleSAML\SAML2\Type\SAMLStringValue|null $serviceDescription
     */
    protected function __construct(
        QNameValue $type,
        SAMLAnyURIListValue $protocolSupportEnumeration,
        ?IDValue $ID = null,
        ?SAMLDateTimeValue $validUntil = null,
        ?DurationValue $cacheDuration = null,
        ?Extensions $extensions = null,
        ?SAMLAnyURIValue $errorURL = null,
        array $keyDescriptors = [],
        ?Organization $organization = null,
        array $contacts = [],
        array $namespacedAttributes = [],
        protected ?LogicalServiceNamesOffered $logicalServiceNamesOffered = null,
        protected ?TokenTypesOffered $tokenTypesOffered = null,
        protected ?ClaimDialectsOffered $claimDialectsOffered = null,
        protected ?ClaimTypesOffered $claimTypesOffered = null,
        protected ?ClaimTypesRequested $claimTypesRequested = null,
        protected ?AutomaticPseudonyms $automaticPseudonyms = null,
        protected ?TargetScopes $targetScopes = null,
        protected ?SAMLStringValue $serviceDisplayName = null,
        protected ?SAMLStringValue $serviceDescription = null,
    ) {
        parent::__construct(
            $type,
            $protocolSupportEnumeration,
            $ID,
            $validUntil,
            $cacheDuration,
            $extensions,
            $errorURL,
            $keyDescriptors,
            $organization,
            $contacts,
            $namespacedAttributes,
        );
    }


    /**
     * Collect the value of the logicalSericeNamesOffered-property
     *
     * @return \SimpleSAML\WebServices\Federation\XML\fed\LogicalServiceNamesOffered|null
     */
    public function getLogicalServiceNamesOffered(): ?LogicalServiceNamesOffered
    {
        return $this->logicalServiceNamesOffered;
    }


    /**
     * Collect the value of the tokenTypesOffered-property
     *
     * @return \SimpleSAML\WebServices\Federation\XML\fed\TokenTypesOffered|null
     */
    public function getTokenTypesOffered(): ?TokenTypesOffered
    {
        return $this->tokenTypesOffered;
    }


    /**
     * Collect the value of the claimDialectsOffered-property
     *
     * @return \SimpleSAML\WebServices\Federation\XML\fed\ClaimDialectsOffered|null
     */
    public function getClaimDialectsOffered(): ?ClaimDialectsOffered
    {
        return $this->claimDialectsOffered;
    }


    /**
     * Collect the value of the claimTypesOffered-property
     *
     * @return \SimpleSAML\WebServices\Federation\XML\fed\ClaimTypesOffered|null
     */
    public function getClaimTypesOffered(): ?ClaimTypesOffered
    {
        return $this->claimTypesOffered;
    }


    /**
     * Collect the value of the claimTypesRequested-property
     *
     * @return \SimpleSAML\WebServices\Federation\XML\fed\ClaimTypesRequested|null
     */
    public function getClaimTypesRequested(): ?ClaimTypesRequested
    {
        return $this->claimTypesRequested;
    }


    /**
     * Collect the value of the automaticPseudonyms-property
     *
     * @return \SimpleSAML\WebServices\Federation\XML\fed\AutomaticPseudonyms|null
     */
    public function getAutomaticPseudonyms(): ?AutomaticPseudonyms
    {
        return $this->automaticPseudonyms;
    }


    /**
     * Collect the value of the targetScopes-property
     *
     * @return \SimpleSAML\WebServices\Federation\XML\fed\TargetScopes|null
     */
    public function getTargetScopes(): ?TargetScopes
    {
        return $this->targetScopes;
    }


    /**
     * Collect the value of the serviceDisplayName-property
     *
     * @return \SimpleSAML\SAML2\Type\SAMLStringValue|null
     */
    public function getServiceDisplayName(): ?SAMLStringValue
    {
        return $this->serviceDisplayName;
    }


    /**
     * Collect the value of the serviceDescription-property
     *
     * @return \SimpleSAML\SAML2\Type\SAMLStringValue|null
     */
    public function getServiceDescription(): ?SAMLStringValue
    {
        return $this->serviceDescription;
    }


    /**
     * Convert this element to XML.
     */
    public function toUnsignedXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toUnsignedXML($parent);

        // md:RoleDescriptor requires an xsi:type. AbstractRoleDescriptor stores it and demands it back in
        // fromXML(), but nothing ever writes it, so the element cannot round-trip its own output.
        $xsiType = $this->getXsiType();

        // An unprefixed QName — from a document that carried this namespace on xmlns — can only resolve
        // through the default namespace, and declaring one here would silently capture any unqualified
        // descendant. Re-express it with this type's own prefix instead: a QName is identified by its
        // {namespace, local name}, so the prefix is lexical only and the value keeps its meaning.
        if ($xsiType->getNamespaceURI() !== null && $xsiType->getNamespacePrefix() === null) {
            $xsiType = QNameValue::fromParts(
                $xsiType->getLocalName(),
                $xsiType->getNamespaceURI(),
                static::getXsiTypePrefix(),
            );
        }

        $namespaceURI = $xsiType->getNamespaceURI();
        $namespacePrefix = $xsiType->getNamespacePrefix();

        // The prefix appears only inside the attribute *value*, so DOM will not declare it for us. Bind it
        // unless it is already in scope for this very namespace. AbstractSignedMdElement::toXML() separately
        // declares the *canonical* prefix once this method returns; this covers a caller-supplied one.
        if (
            $namespaceURI !== null &&
            $namespacePrefix !== null &&
            $e->lookupNamespaceURI($namespacePrefix->getValue()) !== $namespaceURI->getValue()
        ) {
            $e->setAttributeNS(
                'http://www.w3.org/2000/xmlns/',
                'xmlns:' . $namespacePrefix->getValue(),
                $namespaceURI->getValue(),
            );
        }

        $type = new XMLAttribute(C::NS_XSI, 'xsi', 'type', $xsiType);
        $type->toXML($e);

        $this->getLogicalServiceNamesOffered()?->toXML($e);
        $this->getTokenTypesOffered()?->toXML($e);
        $this->getClaimDialectsOffered()?->toXML($e);
        $this->getClaimTypesOffered()?->toXML($e);
        $this->getClaimTypesRequested()?->toXML($e);
        $this->getAutomaticPseudonyms()?->toXML($e);
        $this->getTargetScopes()?->toXML($e);

        $serviceDisplayName = $this->getServiceDisplayName();
        if ($serviceDisplayName !== null) {
            $e->setAttribute('ServiceDisplayName', $serviceDisplayName->getValue());
        }

        $serviceDescription = $this->getServiceDescription();
        if ($serviceDescription !== null) {
            $e->setAttribute('ServiceDescription', $serviceDescription->getValue());
        }

        return $e;
    }
}
