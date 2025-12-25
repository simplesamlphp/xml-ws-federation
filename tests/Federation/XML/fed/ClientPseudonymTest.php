<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SAML2\Type\EmailAddressValue;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractClientPseudonymType;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractFedElement;
use SimpleSAML\WebServices\Federation\XML\fed\ClientPseudonym;
use SimpleSAML\WebServices\Federation\XML\fed\DisplayName;
use SimpleSAML\WebServices\Federation\XML\fed\EMail;
use SimpleSAML\WebServices\Federation\XML\fed\PPID;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\StringValue;
use SimpleSAML\XPath\XPath;

use function dirname;
use function strval;

/**
 * Tests for fed:ClientPseudonym.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('fed')]
#[CoversClass(ClientPseudonym::class)]
#[CoversClass(AbstractClientPseudonymType::class)]
#[CoversClass(AbstractFedElement::class)]
final class ClientPseudonymTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ClientPseudonym::class;

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed/ClientPseudonym.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an ClientPseudonym object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', StringValue::fromString('testval2'));
        $attr3 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr3', StringValue::fromString('testval3'));
        $attr4 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr4', StringValue::fromString('testval4'));

        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement);

        $clientPseudonym = new ClientPseudonym(
            new PPID(StringValue::fromString('MyPPID'), [$attr2]),
            new DisplayName(StringValue::fromString('MyDisplayName'), [$attr3]),
            new EMail(EmailAddressValue::fromString('example@simplesamlphp.org'), [$attr4]),
            [$chunk],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($clientPseudonym),
        );
    }


    /**
     * Adding an empty ClientPseudonym element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $cp = new ClientPseudonym();
        $this->assertTrue($cp->isEmptyElement());
    }


    /**
     */
    public function testMarshallingElementOrdering(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', StringValue::fromString('testval2'));
        $attr3 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr3', StringValue::fromString('testval3'));
        $attr4 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr4', StringValue::fromString('testval4'));

        $chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement);

        $clientPseudonym = new ClientPseudonym(
            new PPID(StringValue::fromString('MyPPID'), [$attr2]),
            new DisplayName(StringValue::fromString('MyDisplayName'), [$attr3]),
            new EMail(EmailAddressValue::fromString('example@simplesamlphp.org'), [$attr4]),
            [$chunk],
            [$attr1],
        );
        $clientPseudonymElement = $clientPseudonym->toXML();

        // Test for a PPID
        $xpCache = XPath::getXPath($clientPseudonymElement);
        $clientPseudonymElements = XPath::xpQuery($clientPseudonymElement, './fed:PPID', $xpCache);
        $this->assertCount(1, $clientPseudonymElements);

        // Test ordering of ClientPseudonym contents
        /** @var \DOMElement[] $clientPseudonymElements */
        $clientPseudonymElements = XPath::xpQuery($clientPseudonymElement, './fed:PPID/following-sibling::*', $xpCache);

        $this->assertCount(3, $clientPseudonymElements);
        $this->assertEquals('fed:DisplayName', $clientPseudonymElements[0]->tagName);
        $this->assertEquals('fed:EMail', $clientPseudonymElements[1]->tagName);
        $this->assertEquals('ssp:Chunk', $clientPseudonymElements[2]->tagName);
    }
}
