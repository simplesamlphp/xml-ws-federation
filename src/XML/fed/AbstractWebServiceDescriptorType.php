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
