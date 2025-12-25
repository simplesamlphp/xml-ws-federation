<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A FilterPseudonyms element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class FilterPseudonyms extends AbstractFilterPseudonymsType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
