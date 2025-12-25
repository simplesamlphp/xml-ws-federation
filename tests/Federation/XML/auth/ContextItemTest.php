<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\auth;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WebServices\Federation\Constants as C;
use SimpleSAML\WebServices\Federation\XML\auth\AbstractAuthElement;
use SimpleSAML\WebServices\Federation\XML\auth\AbstractContextItemType;
use SimpleSAML\WebServices\Federation\XML\auth\ContextItem;
use SimpleSAML\WebServices\Federation\XML\auth\Value;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for auth:ContextItem.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('auth')]
#[CoversClass(ContextItem::class)]
#[CoversClass(AbstractContextItemType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class ContextItemTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ContextItem::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth/ContextItem.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ContextItem object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('value1'));

        $contextItem = new ContextItem(
            AnyURIValue::fromString(C::NAMESPACE),
            AnyURIValue::fromString('urn:x-simplesamlphp:scope'),
            new Value(StringValue::fromString('someValue')),
            null,
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($contextItem),
        );
    }
}
