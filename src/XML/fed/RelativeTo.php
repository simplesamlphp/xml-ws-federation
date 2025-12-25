<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A RelativeTo element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class RelativeTo extends AbstractRelativeToType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
