<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractFedElement;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractFederationType;
use SimpleSAML\WebServices\Federation\XML\fed\Federation;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;

use function dirname;
use function strval;

/**
 * Tests for fed:Federation.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('fed')]
#[CoversClass(Federation::class)]
#[CoversClass(AbstractFederationType::class)]
#[CoversClass(AbstractFedElement::class)]
final class FederationTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Federation::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed/Federation.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a Federation object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', AnyURIValue::fromString('testval1'));
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $federation = new Federation(
            AnyURIValue::fromString('urn:some:uri'),
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($federation),
        );
    }


    /**
     */
    public function testMarshallingEmpty(): void
    {
        $federation = new Federation();
        $this->assertTrue($federation->isEmptyElement());
    }
}
