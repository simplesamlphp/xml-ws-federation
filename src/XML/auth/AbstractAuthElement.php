<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\auth;

use SimpleSAML\WebServices\Federation\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @see http://docs.oasis-open.org/wsfed/federation/v1.2/os/ws-federation-1.2-spec-os.pdf
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractAuthElement extends AbstractElement
{
    public const string NS = C::NS_AUTH;

    public const string NS_PREFIX = 'auth';

    public const string SCHEMA = 'resources/schemas/ws-authorization.xsd';
}
