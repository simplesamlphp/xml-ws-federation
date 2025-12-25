<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use SimpleSAML\WebServices\SecurityPolicy\XML\sp_200702\AbstractNestedPolicyType;
use SimpleSAML\XML\SchemaValidatableElementInterface;
use SimpleSAML\XML\SchemaValidatableElementTrait;

/**
 * An AuthenticationToken element
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class AuthenticationToken extends AbstractNestedPolicyType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;


    public const string NS = AbstractFedElement::NS;

    public const string NS_PREFIX = AbstractFedElement::NS_PREFIX;

    public const string SCHEMA = AbstractFedElement::SCHEMA;
}
