<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\auth;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Federation\XML\auth\AbstractAuthElement;
use SimpleSAML\WebServices\Federation\XML\auth\AbstractStructuredValueType;
use SimpleSAML\WebServices\Federation\XML\auth\StructuredValue;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for auth:StructuredValue.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('auth')]
#[CoversClass(StructuredValue::class)]
#[CoversClass(AbstractStructuredValueType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class StructuredValueTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = StructuredValue::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth/StructuredValue.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a StructuredValue object from scratch.
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

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($structuredValue),
        );
    }
}
