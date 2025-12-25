<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractFedElement;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractSecurityTokenType;
use SimpleSAML\WebServices\Federation\XML\fed\SecurityToken;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for fed:SecurityToken.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('fed')]
#[CoversClass(SecurityToken::class)]
#[CoversClass(AbstractSecurityTokenType::class)]
#[CoversClass(AbstractFedElement::class)]
final class SecurityTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = SecurityToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed/SecurityToken.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a SecurityToken object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $securityToken = new SecurityToken(
            new Chunk($child->documentElement),
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($securityToken),
        );
    }
}
