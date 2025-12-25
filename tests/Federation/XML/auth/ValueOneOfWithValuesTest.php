<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\auth;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Federation\XML\auth\AbstractAuthElement;
use SimpleSAML\WebServices\Federation\XML\auth\AbstractConstrainedManyValueType;
use SimpleSAML\WebServices\Federation\XML\auth\Value;
use SimpleSAML\WebServices\Federation\XML\auth\ValueOneOf;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for auth:Value.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('auth')]
#[CoversClass(ValueOneOf::class)]
#[CoversClass(AbstractConstrainedManyValueType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class ValueOneOfWithValuesTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ValueOneOf::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth/ValueOneOfWithValues.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ValueOneOf object from scratch.
     */
    public function testMarshalling(): void
    {
        $value1 = new Value(StringValue::fromString('MyValue'));
        $value2 = new Value(StringValue::fromString('MyOtherValue'));
        $valueOneOf = new ValueOneOf([$value1, $value2]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($valueOneOf),
        );
    }
}
