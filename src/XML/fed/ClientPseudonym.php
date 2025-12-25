<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A ClientPseudonym element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class ClientPseudonym extends AbstractClientPseudonymType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
