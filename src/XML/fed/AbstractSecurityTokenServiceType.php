<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use DOMElement;
use SimpleSAML\SAML2\Type\SAMLAnyURIListValue;
use SimpleSAML\SAML2\Type\SAMLAnyURIValue;
use SimpleSAML\SAML2\Type\SAMLDateTimeValue;
use SimpleSAML\SAML2\Type\SAMLStringValue;
use SimpleSAML\SAML2\XML\md\Extensions;
use SimpleSAML\SAML2\XML\md\Organization;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\WebServices\Federation\Constants as C;
use SimpleSAML\XMLSchema\Exception\MissingElementException;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\DurationValue;
use SimpleSAML\XMLSchema\Type\IDValue;
use SimpleSAML\XMLSchema\Type\QNameValue;

/**
 * A SecurityTokenServiceType
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractSecurityTokenServiceType extends AbstractWebServiceDescriptorType
{
    public const string XSI_TYPE_PREFIX = 'fed';

    public const string XSI_TYPE_NAME = 'SecurityTokenServiceType';

    public const string XSI_TYPE_NAMESPACE = C::NS_FED;


    /**
     * SecurityTokenServiceType constructor.
     *
     * @param \SimpleSAML\XMLSchema\Type\QNameValue $type
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
     * @param \SimpleSAML\WebServices\Federation\XML\fed\SecurityTokenServiceEndpoint[] $securityTokenServiceEndpoint
     * @param (
     *   \SimpleSAML\WebServices\Federation\XML\fed\SingleSignOutSubscriptionEndpoint[]
     * ) $singleSignOutSubscriptionEndpoint
     * @param (
     *   \SimpleSAML\WebServices\Federation\XML\fed\SingleSignOutNotificationEndpoint[]
     * ) $singleSignOutNotificationEndpoint
     * @param \SimpleSAML\WebServices\Federation\XML\fed\PassiveRequestorEndpoint[] $passiveRequestorEndpoint
     */
    final public function __construct(
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
        ?LogicalServiceNamesOffered $logicalServiceNamesOffered = null,
        ?TokenTypesOffered $tokenTypesOffered = null,
        ?ClaimDialectsOffered $claimDialectsOffered = null,
        ?ClaimTypesOffered $claimTypesOffered = null,
        ?ClaimTypesRequested $claimTypesRequested = null,
        ?AutomaticPseudonyms $automaticPseudonyms = null,
        ?TargetScopes $targetScopes = null,
        ?SAMLStringValue $serviceDisplayName = null,
        ?SAMLStringValue $serviceDescription = null,
        protected array $securityTokenServiceEndpoint = [],
        protected array $singleSignOutSubscriptionEndpoint = [],
        protected array $singleSignOutNotificationEndpoint = [],
        protected array $passiveRequestorEndpoint = [],
    ) {
        Assert::minCount($securityTokenServiceEndpoint, 1, MissingElementException::class);
        Assert::allIsInstanceOf(
            $securityTokenServiceEndpoint,
            SecurityTokenServiceEndpoint::class,
            SchemaViolationException::class,
        );
        Assert::allIsInstanceOf(
            $singleSignOutSubscriptionEndpoint,
            SingleSignOutSubscriptionEndpoint::class,
            SchemaViolationException::class,
        );
        Assert::allIsInstanceOf(
            $singleSignOutNotificationEndpoint,
            SingleSignOutNotificationEndpoint::class,
            SchemaViolationException::class,
        );
        Assert::allIsInstanceOf(
            $passiveRequestorEndpoint,
            PassiveRequestorEndpoint::class,
            SchemaViolationException::class,
        );

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
            $logicalServiceNamesOffered,
            $tokenTypesOffered,
            $claimDialectsOffered,
            $claimTypesOffered,
            $claimTypesRequested,
            $automaticPseudonyms,
            $targetScopes,
            $serviceDisplayName,
            $serviceDescription,
        );
    }


    /**
     * Collect the value of the securityTokenServiceEndpoint-property
     *
     * @return \SimpleSAML\WebServices\Federation\XML\fed\SecurityTokenServiceEndpoint[]
     */
    public function getSecurityTokenServiceEndpoint(): array
    {
        return $this->securityTokenServiceEndpoint;
    }


    /**
     * Collect the value of the singleSignOutSubscriptionEndpoint-property
     *
     * @return \SimpleSAML\WebServices\Federation\XML\fed\SingleSignOutSubscriptionEndpoint[]
     */
    public function getSingleSignOutSubscriptionEndpoint(): array
    {
        return $this->singleSignOutSubscriptionEndpoint;
    }


    /**
     * Collect the value of the singleSignOutNotificationtionEndpoint-property
     *
     * @return \SimpleSAML\WebServices\Federation\XML\fed\SingleSignOutNotificationEndpoint[]
     */
    public function getSingleSignOutNotificationEndpoint(): array
    {
        return $this->singleSignOutNotificationEndpoint;
    }


    /**
     * Collect the value of the passiveRequestorEndpoint-property
     *
     * @return \SimpleSAML\WebServices\Federation\XML\fed\PassiveRequestorEndpoint[]
     */
    public function getPassiveRequestorEndpoint(): array
    {
        return $this->passiveRequestorEndpoint;
    }


    /**
     * Convert this element to XML.
     */
    public function toUnsignedXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toUnsignedXML($parent);

        foreach ($this->getSecurityTokenServiceEndpoint() as $stse) {
            $stse->toXML($e);
        }

        foreach ($this->getSingleSignOutSubscriptionEndpoint() as $ssose) {
            $ssose->toXML($e);
        }

        foreach ($this->getSingleSignOutNotificationEndpoint() as $ssone) {
            $ssone->toXML($e);
        }

        foreach ($this->getPassiveRequestorEndpoint() as $pre) {
            $pre->toXML($e);
        }

        return $e;
    }
}
