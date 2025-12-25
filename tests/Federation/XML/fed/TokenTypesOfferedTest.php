<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractFedElement;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractTokenTypesOfferedType;
use SimpleSAML\WebServices\Federation\XML\fed\TokenType;
use SimpleSAML\WebServices\Federation\XML\fed\TokenTypesOffered;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for fed:TokenTypesOffered.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('fed')]
#[CoversClass(TokenTypesOffered::class)]
#[CoversClass(AbstractTokenTypesOfferedType::class)]
#[CoversClass(AbstractFedElement::class)]
final class TokenTypesOfferedTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = TokenTypesOffered::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed/TokenTypesOffered.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a TokenTypesOffered object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', StringValue::fromString('testval2'));
        $child1 = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );
        $child2 = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">OtherChunk</ssp:Chunk>',
        );

        $tokenType = new TokenType(
            AnyURIValue::fromString('urn:some:uri'),
            [new Chunk($child1->documentElement)],
            [$attr2],
        );

        $tokenTypesOffered = new TokenTypesOffered(
            [$tokenType],
            [new Chunk($child2->documentElement)],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($tokenTypesOffered),
        );
    }
}
