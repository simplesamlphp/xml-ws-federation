<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractFedElement;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractPseudonymType;
use SimpleSAML\WebServices\Federation\XML\fed\ProofToken;
use SimpleSAML\WebServices\Federation\XML\fed\Pseudonym;
use SimpleSAML\WebServices\Federation\XML\fed\PseudonymBasis;
use SimpleSAML\WebServices\Federation\XML\fed\RelativeTo;
use SimpleSAML\WebServices\Federation\XML\fed\SecurityToken;
use SimpleSAML\WebServices\Security\Type\DateTimeValue;
use SimpleSAML\WebServices\Security\XML\wsu\Expires;
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
 * Tests for fed:Pseudonym.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('fed')]
#[CoversClass(Pseudonym::class)]
#[CoversClass(AbstractPseudonymType::class)]
#[CoversClass(AbstractFedElement::class)]
final class PseudonymTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /** @var \SimpleSAML\XML\Chunk $basis */
    protected static Chunk $basis;

    /** @var \SimpleSAML\XML\Chunk $chunk */
    protected static Chunk $chunk;

    /** @var \SimpleSAML\XML\Chunk $proof */
    protected static Chunk $proof;

    /** @var \SimpleSAML\XML\Chunk $relative */
    protected static Chunk $relative;

    /** @var \SimpleSAML\XML\Chunk $security */
    protected static Chunk $security;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Pseudonym::class;

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed/Pseudonym.xml',
        );

        self::$chunk = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement);

        self::$basis = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Basis</ssp:Chunk>',
        )->documentElement);

        self::$relative = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Relative</ssp:Chunk>',
        )->documentElement);

        self::$security = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Security</ssp:Chunk>',
        )->documentElement);

        self::$proof = new Chunk(DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Proof</ssp:Chunk>',
        )->documentElement);
    }


    // test marshalling


    /**
     * Test creating an Pseudonym object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', StringValue::fromString('testval2'));
        $attr3 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr3', StringValue::fromString('testval3'));
        $attr4 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr4', StringValue::fromString('testval4'));
        $attr5 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr5', StringValue::fromString('testval5'));

        $pseudonymBasis = new PseudonymBasis(
            self::$basis,
            [$attr2],
        );

        $relativeTo = new RelativeTo(
            [self::$relative],
            [$attr3],
        );

        $expires = new Expires(DateTimeValue::fromString('2001-10-13T09:00:00Z'));

        $securityToken = new SecurityToken(
            self::$security,
            [$attr4],
        );

        $proofToken = new ProofToken(
            self::$proof,
            [$attr5],
        );

        $pseudonym = new Pseudonym(
            $pseudonymBasis,
            $relativeTo,
            [$expires, $securityToken, $proofToken, self::$chunk],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($pseudonym),
        );
    }


    /**
     */
    public function testMarshallingElementOrder(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', StringValue::fromString('testval2'));
        $attr3 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr3', StringValue::fromString('testval3'));
        $attr4 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr4', StringValue::fromString('testval4'));
        $attr5 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr5', StringValue::fromString('testval5'));

        $pseudonymBasis = new PseudonymBasis(
            self::$basis,
            [$attr2],
        );

        $relativeTo = new RelativeTo(
            [self::$relative],
            [$attr3],
        );

        $expires = new Expires(DateTimeValue::fromString('2001-10-13T09:00:00Z'));

        $securityToken = new SecurityToken(
            self::$security,
            [$attr4],
        );

        $proofToken = new ProofToken(
            self::$proof,
            [$attr5],
        );

        $pseudonym = new Pseudonym(
            $pseudonymBasis,
            $relativeTo,
            [$expires, $securityToken, $proofToken, self::$chunk],
            [$attr1],
        );
        $pseudonymElement = $pseudonym->toXML();

        // Test for a PseudonymBasis
        $xpCache = XPath::getXPath($pseudonymElement);
        $pseudonymBasisElements = XPath::xpQuery($pseudonymElement, './fed:PseudonymBasis', $xpCache);
        $this->assertCount(1, $pseudonymBasisElements);

        // Test ordering of Pseudonym contents
        /** @var \DOMElement[] $pseudonymElements */
        $pseudonymElements = XPath::xpQuery($pseudonymElement, './fed:PseudonymBasis/following-sibling::*', $xpCache);

        $this->assertCount(5, $pseudonymElements);
        $this->assertEquals('fed:RelativeTo', $pseudonymElements[0]->tagName);
        $this->assertEquals('wsu:Expires', $pseudonymElements[1]->tagName);
        $this->assertEquals('fed:SecurityToken', $pseudonymElements[2]->tagName);
        $this->assertEquals('fed:ProofToken', $pseudonymElements[3]->tagName);
        $this->assertEquals('ssp:Chunk', $pseudonymElements[4]->tagName);
    }
}
