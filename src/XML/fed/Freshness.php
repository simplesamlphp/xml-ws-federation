<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A Freshness element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class Freshness extends AbstractFreshnessType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
