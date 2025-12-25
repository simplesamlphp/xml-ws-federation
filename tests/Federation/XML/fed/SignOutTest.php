<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractFedElement;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractSignOutType;
use SimpleSAML\WebServices\Federation\XML\fed\Realm;
use SimpleSAML\WebServices\Federation\XML\fed\SignOut;
use SimpleSAML\WebServices\Federation\XML\fed\SignOutBasis;
use SimpleSAML\WebServices\Security\Type\IDValue;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;
use SimpleSAML\XPath\XPath;

use function dirname;
use function strval;

/**
 * Tests for fed:SignOut.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('fed')]
#[CoversClass(SignOut::class)]
#[CoversClass(AbstractSignOutType::class)]
#[CoversClass(AbstractFedElement::class)]
final class SignOutTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /** @var \SimpleSAML\XML\Chunk $basis */
    protected static Chunk $basis;

    /** @var \SimpleSAML\XML\Chunk $chunk */
    protected static Chunk $chunk;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = SignOut::class;

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed/SignOut.xml',
        );

        self::$chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement);

        self::$basis = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Basis</ssp:Chunk>',
        )->documentElement);
    }


    // test marshalling


    /**
     * Test creating an SignOut object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', StringValue::fromString('testval2'));

        $signOutBasis = new SignOutBasis(
            [self::$basis],
            [$attr2],
        );

        $realm = new Realm(AnyURIValue::fromString('urn:x-simplesamlphp:namespace'));

        $signOut = new SignOut(
            $signOutBasis,
            $realm,
            IDValue::fromString('phpunit'),
            [self::$chunk],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($signOut),
        );
    }


    /**
     */
    public function testMarshallingElementOrder(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', StringValue::fromString('testval2'));

        $signOutBasis = new SignOutBasis(
            [self::$basis],
            [$attr2],
        );

        $realm = new Realm(AnyURIValue::fromString('urn:x-simplesamlphp:namespace'));

        $signOut = new SignOut(
            $signOutBasis,
            $realm,
            IDValue::fromString('phpunit'),
            [self::$chunk],
            [$attr1],
        );
        $signOutElement = $signOut->toXML();

        // Test for a SignOut
        $xpCache = XPath::getXPath($signOutElement);
        $signOutElements = XPath::xpQuery($signOutElement, './fed:Realm', $xpCache);
        $this->assertCount(1, $signOutElements);

        // Test ordering of SignOUt contents
        /** @var \DOMElement[] $signOutElements */
        $signOutElements = XPath::xpQuery($signOutElement, './fed:Realm/following-sibling::*', $xpCache);

        $this->assertCount(2, $signOutElements);
        $this->assertEquals('fed:SignOutBasis', $signOutElements[0]->tagName);
        $this->assertEquals('ssp:Chunk', $signOutElements[1]->tagName);
    }
}
