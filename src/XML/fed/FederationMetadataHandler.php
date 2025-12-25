<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * A FederationMetadataHandler element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class FederationMetadataHandler extends AbstractFederationMetadataHandlerType implements
    SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
