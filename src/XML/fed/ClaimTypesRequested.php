<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A ClaimTypesRequested element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class ClaimTypesRequested extends AbstractClaimTypesRequestedType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
