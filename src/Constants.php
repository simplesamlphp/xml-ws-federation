<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation;

/**
 * Class holding constants relevant for WS-Federation.
 *
 * @package simplesamlphp/xml-ws-federation
 */

class Constants extends \SimpleSAML\WebServices\Security\Constants
{
    /**
     * The namespace for WS-Authorization protocol.
     */
    public const string NS_AUTH = 'http://docs.oasis-open.org/wsfed/authorization/200706';

    /**
     * The namespace for WS-Federation protocol.
     */
    public const string NS_FED = 'http://docs.oasis-open.org/wsfed/federation/200706';
}
