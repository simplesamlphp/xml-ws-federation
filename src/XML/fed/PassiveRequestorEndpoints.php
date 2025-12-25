<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the PassiveRequestorEndpoints element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class PassiveRequestorEndpoints extends AbstractEndpointType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
