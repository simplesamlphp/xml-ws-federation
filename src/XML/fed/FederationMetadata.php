<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A FederationMetadata element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class FederationMetadata extends AbstractFederationMetadataType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
