<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the LogicalServiceNamesOffered element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class LogicalServiceNamesOffered extends AbstractLogicalServiceNamesOfferedType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
