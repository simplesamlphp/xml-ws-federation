<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\auth;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class representing WS-authorization ClaimType.
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class ClaimType extends AbstractClaimType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
