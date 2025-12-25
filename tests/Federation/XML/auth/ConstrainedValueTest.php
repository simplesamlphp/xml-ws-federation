<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\auth;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Federation\XML\auth\AbstractAuthElement;
use SimpleSAML\WebServices\Federation\XML\auth\AbstractConstrainedValueType;
use SimpleSAML\WebServices\Federation\XML\auth\ConstrainedValue;
//use SimpleSAML\WebServices\Federation\XML\auth\StructuredValue;
use SimpleSAML\WebServices\Federation\XML\auth\Value;
use SimpleSAML\WebServices\Federation\XML\auth\ValueGreaterThan;
use SimpleSAML\WebServices\Federation\XML\auth\ValueGreaterThanOrEqual;
use SimpleSAML\WebServices\Federation\XML\auth\ValueLessThan;
use SimpleSAML\WebServices\Federation\XML\auth\ValueLessThanOrEqual;
use SimpleSAML\XML\Attribute as XMLAttribute;
//use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XMLSchema\Type\BooleanValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for auth:ConstrainedValue.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('auth')]
#[CoversClass(ConstrainedValue::class)]
#[CoversClass(AbstractConstrainedValueType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class ConstrainedValueTest extends TestCase
{
    private static string $resourcePath;

    //private static StructuredValue $structuredValue;

    private static Value $value;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$resourcePath = dirname(__FILE__, 4) . '/resources/xml/';

        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        /**
        self::$structuredValue = new StructuredValue(
            [new Chunk($child->documentElement)],
            [$attr1],
        );
        */

        self::$value = new Value(StringValue::fromString('MyValue'));
    }


    // test marshalling


    /**
     * Test creating a ConstrainedValue object from scratch.
     *
     * @param class-string $class
     * @param string $xmlRepresentation
     */
    #[DataProvider('classProvider')]
    public function testMarshalling(string $class, string $xmlRepresentation): void
    {
        $xmlRepresentation = DOMDocumentFactory::fromFile(
            self::$resourcePath . $xmlRepresentation,
        );

        /**
         * @var (
         *   \SimpleSAML\WebServices\Federation\XML\auth\ValueLessThan|
         *   \SimpleSAML\WebServices\Federation\XML\auth\ValueLessThanOrEqual|
         *   \SimpleSAML\WebServices\Federation\XML\auth\ValueGreaterThan|
         *   \SimpleSAML\WebServices\Federation\XML\auth\ValueGreaterThanOrEqual|
         *   \SimpleSAML\WebServices\Federation\XML\auth\ValueInRangen|
         *   \SimpleSAML\WebServices\Federation\XML\auth\ValueOneOf
         * ) $item
         */
        $item = new $class(self::$value, null);
        $constrainedValue = new ConstrainedValue($item, [], BooleanValue::fromBoolean(true));

        $this->assertEquals(
            $xmlRepresentation->saveXML($xmlRepresentation->documentElement),
            strval($constrainedValue),
        );
    }


    // test unmarshalling


    /**
     * Test creating a ConstrainedValue from XML.
     *
     * @param class-string $class
     * @param string $xmlRepresentation
     */
    #[DataProvider('classProvider')]
    public function testUnmarshalling(string $class, string $xmlRepresentation): void
    {
        $xmlRepresentation = DOMDocumentFactory::fromFile(
            self::$resourcePath . $xmlRepresentation,
        );

        $constrainedValue = ConstrainedValue::fromXML($xmlRepresentation->documentElement);
        $this->assertEquals(
            $xmlRepresentation->saveXML($xmlRepresentation->documentElement),
            strval($constrainedValue),
        );
    }


    /**
     * @return array<string, list<string>>
     */
    public static function classProvider(): array
    {
        return [
            /** TODO
            'auth:ValueInRangen' => [
                ValueInRangen::class,
                'auth/ConstrainedValueWithValueInRangen.xml',
            ],
            'auth:ValueOneOf' => [
                ValueOneOf::class,
                'auth/ConstrainedValueWithValueOneOf.xml',
            ],
            */
            'auth:ValueLessThan' => [
                ValueLessThan::class,
                'auth/ConstrainedValueWithValueLessThan.xml',
            ],
            'auth:ValueLessThanOrEqual' => [
                ValueLessThanOrEqual::class,
                'auth/ConstrainedValueWithValueLessThanOrEqual.xml',
            ],
            'auth:ValueGreaterThan' => [
                ValueGreaterThan::class,
                'auth/ConstrainedValueWithValueGreaterThan.xml',
            ],
            'auth:ValueGreaterThanOrEqual' => [
                ValueGreaterThanOrEqual::class,
                'auth/ConstrainedValueWithValueGreaterThanOrEqual.xml',
            ],
        ];
    }
}
