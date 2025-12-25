<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\auth;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Federation\XML\auth\AbstractAuthElement;
use SimpleSAML\WebServices\Federation\XML\auth\AbstractConstrainedSingleValueType;
use SimpleSAML\WebServices\Federation\XML\auth\StructuredValue;
use SimpleSAML\WebServices\Federation\XML\auth\ValueLessThan;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for auth:ValueLessThan.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('auth')]
#[CoversClass(ValueLessThan::class)]
#[CoversClass(AbstractConstrainedSingleValueType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class ValueLessThanTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ValueLessThan::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth/ValueLessThan.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ValueLessThan object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $structuredValue = new StructuredValue(
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $valueLessThan = new ValueLessThan(null, $structuredValue);

        $this->assertFalse($valueLessThan->isEmptyElement());
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($valueLessThan),
        );
    }
}
