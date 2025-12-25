<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A RequestProofToken element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class RequestProofToken extends AbstractRequestProofTokenType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
