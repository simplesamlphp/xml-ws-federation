<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\auth;

use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

/**
 * Class representing WS-authorization Value.
 *
 * @package simplesamlphp/xml-ws-federation
 */
final class Value extends AbstractAuthElement
{
    use TypedTextContentTrait;


    public const string TEXTCONTENT_TYPE = StringValue::class;
}
