<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * Class defining the SignOut element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class SignOut extends AbstractSignOutType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;
}
