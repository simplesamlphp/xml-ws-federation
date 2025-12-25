<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the SingleSignOutSubscriptionEndpoints element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class SingleSignOutSubscriptionEndpoints extends AbstractEndpointType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
