<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\WebServices\Federation\XML\fed\AbstractAssertionType;
use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A RequiresGenericClaimDialect element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class RequiresGenericClaimDialect extends AbstractAssertionType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
