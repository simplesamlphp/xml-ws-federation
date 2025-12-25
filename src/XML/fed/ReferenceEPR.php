<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\WebServices\Addressing\XML\wsa_200508\AbstractEndpointReferenceType;

/**
 * A ReferenceEPR element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class ReferenceEPR extends AbstractEndpointReferenceType
{
    public const string NS = AbstractFedElement::NS;

    public const string NS_PREFIX = AbstractFedElement::NS_PREFIX;

    /** The exclusions for the xs:any element */
    public const array XS_ANY_ELT_EXCLUSIONS = [
        ['http://www.w3.org/2005/08/addressing', 'Address'],
        ['http://www.w3.org/2005/08/addressing', 'Metadata'],
        ['http://www.w3.org/2005/08/addressing', 'ReferenceParameters'],
    ];
}
