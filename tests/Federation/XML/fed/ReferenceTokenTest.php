<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\fed;

use DOMElement;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WebServices\Federation\Constants as C;
use SimpleSAML\WebServices\Addressing\XML\wsa_200508\Address;
use SimpleSAML\WebServices\Addressing\XML\wsa_200508\Metadata;
use SimpleSAML\WebServices\Addressing\XML\wsa_200508\ReferenceParameters;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractReferenceTokenType;
use SimpleSAML\WebServices\Federation\XML\fed\ReferenceDigest;
use SimpleSAML\WebServices\Federation\XML\fed\ReferenceEPR;
use SimpleSAML\WebServices\Federation\XML\fed\ReferenceToken;
use SimpleSAML\WebServices\Federation\XML\fed\ReferenceType;
use SimpleSAML\WebServices\Federation\XML\fed\SerialNo;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\Base64BinaryValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for fed:ReferenceToken.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('fed')]
#[CoversClass(ReferenceToken::class)]
#[CoversClass(AbstractReferenceTokenType::class)]
final class ReferenceTokenTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /** @var \DOMElement $referenceParametersContent */
    protected static DOMElement $referenceParametersContent;

    /** @var \DOMElement $metadataContent */
    protected static DOMElement $metadataContent;

    /** @var \DOMElement $customContent */
    protected static DOMElement $customContent;

    /** @var \DOMElement $someChunk */
    protected static DOMElement $someChunk;

    /** @var \DOMElement $some */
    protected static DOMElement $some;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ReferenceToken::class;

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed/ReferenceToken.xml',
        );

        self::$referenceParametersContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Pears</m:Item></m:GetPrice>',
        )->documentElement;

        self::$metadataContent = DOMDocumentFactory::fromString(
            '<m:GetPrice xmlns:m="https://www.w3schools.com/prices"><m:Item>Apples</m:Item></m:GetPrice>',
        )->documentElement;

        self::$customContent = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        )->documentElement;

        self::$some = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">Some</ssp:Chunk>',
        )->documentElement;
    }


    // test marshalling


    /**
     * Test creating an ReferenceToken object from scratch.
     */
    public function testMarshalling(): void
    {
        $doc = DOMDocumentFactory::fromString('<root/>');

        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr2', StringValue::fromString('testval2'));
        $attr3 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr3', StringValue::fromString('testval3'));
        $attr4 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr4', StringValue::fromString('testval4'));
        $attr5 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr5', StringValue::fromString('testval5'));
        $attr6 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr6', StringValue::fromString('testval6'));
        $attr7 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr7', StringValue::fromString('testval7'));
        $attr8 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr8', StringValue::fromString('testval8'));

        $referenceParameters = new ReferenceParameters([new Chunk(self::$referenceParametersContent)], [$attr4]);
        $metadata = new Metadata([new Chunk(self::$metadataContent)], [$attr5]);
        $chunk = new Chunk(self::$customContent);
        $some = new Chunk(self::$some);

        $referenceEPR = new ReferenceEPR(
            new Address(
                AnyURIValue::fromString('https://login.microsoftonline.com/login.srf'),
                [$attr3],
            ),
            $referenceParameters,
            $metadata,
            [$chunk],
            [$attr2],
        );

        $referenceDigest = new ReferenceDigest(
            Base64BinaryValue::fromString('/CTj03d1DB5e2t7CTo9BEzCf5S9NRzwnBgZRlm32REI='),
            [$attr6],
        );
        $referenceType = new ReferenceType(AnyURIValue::fromString(C::NAMESPACE), [$attr7]);
        $serialNo = new SerialNo(AnyURIValue::fromString(C::NAMESPACE), [$attr8]);

        $referenceToken = new ReferenceToken(
            [$referenceEPR],
            $referenceDigest,
            $referenceType,
            $serialNo,
            [$some],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($referenceToken),
        );
    }
}
