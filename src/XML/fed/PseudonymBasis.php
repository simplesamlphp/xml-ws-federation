<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A PseudonymBasis element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class PseudonymBasis extends AbstractPseudonymBasisType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
