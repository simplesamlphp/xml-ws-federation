<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use DOMElement;
use SimpleSAML\SAML2\Type\SAMLAnyURIListValue;
use SimpleSAML\SAML2\Type\SAMLAnyURIValue;
use SimpleSAML\SAML2\Type\SAMLDateTimeValue;
use SimpleSAML\SAML2\Type\SAMLStringValue;
use SimpleSAML\SAML2\XML\md\ContactPerson;
use SimpleSAML\SAML2\XML\md\Extensions;
use SimpleSAML\SAML2\XML\md\KeyDescriptor;
use SimpleSAML\SAML2\XML\md\Organization;
use SimpleSAML\WebServices\Federation\Assert\Assert;
use SimpleSAML\XMLSchema\Constants as C;
use SimpleSAML\XMLSchema\Exception\InvalidDOMElementException;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Exception\TooManyElementsException;
use SimpleSAML\XMLSchema\Type\DurationValue;
use SimpleSAML\XMLSchema\Type\IDValue;
use SimpleSAML\XMLSchema\Type\QNameValue;
use SimpleSAML\XMLSecurity\XML\ds\Signature;

/**
 * Class representing WS-federation SecurityTokenServiceType RoleDescriptor.
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class SecurityTokenServiceType extends AbstractSecurityTokenServiceType
{
    /**
     * Convert XML into a SecurityTokenServiceType RoleDescriptor
     *
     * @throws \SimpleSAML\XMLSchema\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     * @throws \SimpleSAML\XMLSchema\Exception\TooManyElementsException
     *   if too many child-elements of a type are specified
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'RoleDescriptor', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        Assert::true(
            $xml->hasAttributeNS(C::NS_XSI, 'type'),
            'Missing required xsi:type in <saml:RoleDescriptor> element.',
            SchemaViolationException::class,
        );

        $type = QNameValue::fromDocument($xml->getAttributeNS(C::NS_XSI, 'type'), $xml);

        $orgs = Organization::getChildrenOfClass($xml);
        Assert::maxCount(
            $orgs,
            1,
            'More than one Organization found in this descriptor',
            TooManyElementsException::class,
        );

        $extensions = Extensions::getChildrenOfClass($xml);
        Assert::maxCount(
            $extensions,
            1,
            'Only one md:Extensions element is allowed.',
            TooManyElementsException::class,
        );

        $logicalServiceNamesOffered = LogicalServiceNamesOffered::getChildrenOfClass($xml);
        Assert::maxCount(
            $logicalServiceNamesOffered,
            1,
            'Only one fed:LogicalServiceNamesOffered is allowed.',
            TooManyElementsException::class,
        );

        $tokenTypesOffered = TokenTypesOffered::getChildrenOfClass($xml);
        Assert::maxCount(
            $tokenTypesOffered,
            1,
            'Only one fed:TokenTypesOffered is allowed.',
            TooManyElementsException::class,
        );

        $claimDialectsOffered = ClaimDialectsOffered::getChildrenOfClass($xml);
        Assert::maxCount(
            $claimDialectsOffered,
            1,
            'Only one fed:ClaimDialectsOffered is allowed.',
            TooManyElementsException::class,
        );

        $claimTypesOffered = ClaimTypesOffered::getChildrenOfClass($xml);
        Assert::maxCount(
            $claimTypesOffered,
            1,
            'Only one fed:ClaimTypesOffered is allowed.',
            TooManyElementsException::class,
        );

        $claimTypesRequested = ClaimTypesRequested::getChildrenOfClass($xml);
        Assert::maxCount(
            $claimTypesRequested,
            1,
            'Only one fed:ClaimTypesRequested is allowed.',
            TooManyElementsException::class,
        );

        $automaticPseudonyms = AutomaticPseudonyms::getChildrenOfClass($xml);
        Assert::maxCount(
            $automaticPseudonyms,
            1,
            'Only one fed:AutomaticPseudonyms is allowed.',
            TooManyElementsException::class,
        );

        $targetScopes = TargetScopes::getChildrenOfClass($xml);
        Assert::maxCount(
            $targetScopes,
            1,
            'Only one fed:TargetScopes is allowed.',
            TooManyElementsException::class,
        );

        $signature = Signature::getChildrenOfClass($xml);
        Assert::maxCount(
            $signature,
            1,
            'Only one ds:Signature element is allowed.',
            TooManyElementsException::class,
        );

        $securityTokenServiceType = new static(
            $type,
            self::getAttribute($xml, 'protocolSupportEnumeration', SAMLAnyURIListValue::class),
            self::getOptionalAttribute($xml, 'ID', IDValue::class, null),
            self::getOptionalAttribute($xml, 'validUntil', SAMLDateTimeValue::class, null),
            self::getOptionalAttribute($xml, 'cacheDuration', DurationValue::class, null),
            array_pop($extensions),
            self::getOptionalAttribute($xml, 'errorURL', SAMLAnyURIValue::class, null),
            KeyDescriptor::getChildrenOfClass($xml),
            array_pop($orgs),
            ContactPerson::getChildrenOfClass($xml),
            self::getAttributesNSFromXML($xml),
            array_pop($logicalServiceNamesOffered),
            array_pop($tokenTypesOffered),
            array_pop($claimDialectsOffered),
            array_pop($claimTypesOffered),
            array_pop($claimTypesRequested),
            array_pop($automaticPseudonyms),
            array_pop($targetScopes),
            self::getOptionalAttribute($xml, 'ServiceDisplayName', SAMLStringValue::class, null),
            self::getOptionalAttribute($xml, 'ServiceDescription', SAMLStringValue::class, null),
            SecurityTokenServiceEndpoint::getChildrenOfClass($xml),
            SingleSignOutSubscriptionEndpoint::getChildrenOfClass($xml),
            SingleSignOutNotificationEndpoint::getChildrenOfClass($xml),
            PassiveRequestorEndpoint::getChildrenOfClass($xml),
        );

        if (!empty($signature)) {
            $securityTokenServiceType->setSignature($signature[0]);
            $securityTokenServiceType->setXML($xml);
        }

        return $securityTokenServiceType;
    }
}
