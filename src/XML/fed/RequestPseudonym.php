<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A RequestPseudonym element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class RequestPseudonym extends AbstractRequestPseudonymType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
