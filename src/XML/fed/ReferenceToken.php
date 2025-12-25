<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A ReferenceToken element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class ReferenceToken extends AbstractReferenceTokenType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
