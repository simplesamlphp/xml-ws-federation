<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A Pseudonym element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class Pseudonym extends AbstractPseudonymType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
