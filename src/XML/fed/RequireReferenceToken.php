<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\WebServices\SecurityPolicy\XML\sp_200702\AbstractTokenAssertionType;
use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * An RequireReferenceToken element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class RequireReferenceToken extends AbstractTokenAssertionType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;


    public const string NS = AbstractFedElement::NS;

    public const string NS_PREFIX = AbstractFedElement::NS_PREFIX;

    public const string SCHEMA = AbstractFedElement::SCHEMA;
}
