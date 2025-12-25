<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractClaimDialectType;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractFedElement;
use SimpleSAML\WebServices\Federation\XML\fed\ClaimDialect;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for fed:ClaimDialect.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('fed')]
#[CoversClass(ClaimDialect::class)]
#[CoversClass(AbstractClaimDialectType::class)]
#[CoversClass(AbstractFedElement::class)]
final class ClaimDialectTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ClaimDialect::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed/ClaimDialect.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ClaimDialect object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $claimDialect = new ClaimDialect(
            AnyURIValue::fromString('urn:some:uri'),
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($claimDialect),
        );
    }


    /**
     */
    public function testMarshallingEmpty(): void
    {
        $this->expectException(AssertionFailedException::class);
        new ClaimDialect();
    }
}
