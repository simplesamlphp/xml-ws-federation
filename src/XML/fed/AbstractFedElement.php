<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\WebServices\Federation\Constants as C;
use SimpleSAML\XML\AbstractElement;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @see http://docs.oasis-open.org/wsfed/federation/v1.2/ws-federation.pdf
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractFedElement extends AbstractElement
{
    public const string NS = C::NS_FED;

    public const string NS_PREFIX = 'fed';

    public const string SCHEMA = 'resources/schemas/ws-federation.xsd';
}
