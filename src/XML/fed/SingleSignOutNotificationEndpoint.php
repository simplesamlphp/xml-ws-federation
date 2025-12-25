<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the SingleSignOutNotificationEndpoint element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class SingleSignOutNotificationEndpoint extends AbstractEndpointType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
