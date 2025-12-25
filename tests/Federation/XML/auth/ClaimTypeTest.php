<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\auth;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WebServices\Federation\Constants as C;
use SimpleSAML\WebServices\Federation\Utils\XPath;
use SimpleSAML\WebServices\Federation\XML\auth\AbstractAuthElement;
use SimpleSAML\WebServices\Federation\XML\auth\AbstractClaimType;
use SimpleSAML\WebServices\Federation\XML\auth\ClaimType;
use SimpleSAML\WebServices\Federation\XML\auth\Description;
use SimpleSAML\WebServices\Federation\XML\auth\DisplayName;
use SimpleSAML\WebServices\Federation\XML\auth\DisplayValue;
use SimpleSAML\WebServices\Federation\XML\auth\Value;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\BooleanValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for auth:ClaimType.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('auth')]
#[CoversClass(ClaimType::class)]
#[CoversClass(AbstractClaimType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class ClaimTypeTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ClaimType::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/auth/ClaimType.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a ClaimType object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('value1'));
        $claimType = new ClaimType(
            AnyURIValue::fromString(C::NAMESPACE),
            BooleanValue::fromBoolean(true),
            new DisplayName(StringValue::fromString('someDisplayName')),
            new Description(StringValue::fromString('someDescription')),
            new DisplayValue(StringValue::fromString('someDisplayValue')),
            new Value(StringValue::fromString('someValue')),
            [$attr],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($claimType),
        );
    }


    /**
     */
    public function testMarshallingElementOrdering(): void
    {
        $attr = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('value1'));
        $claimType = new ClaimType(
            AnyURIValue::fromString(C::NAMESPACE),
            BooleanValue::fromBoolean(true),
            new DisplayName(StringValue::fromString('someDisplayName')),
            new Description(StringValue::fromString('someDescription')),
            new DisplayValue(StringValue::fromString('someDisplayValue')),
            new Value(StringValue::fromString('someValue')),
            [$attr],
        );
        $claimTypeElement = $claimType->toXML();

        // Test for a DisplayName
        $xpCache = XPath::getXPath($claimTypeElement);
        $claimTypeElements = XPath::xpQuery($claimTypeElement, './auth:DisplayName', $xpCache);
        $this->assertCount(1, $claimTypeElements);

        // Test ordering of ClaimType contents
        /** @var \DOMElement[] $claimTypeElements */
        $claimTypeElements = XPath::xpQuery($claimTypeElement, './auth:DisplayName/following-sibling::*', $xpCache);
        $this->assertCount(3, $claimTypeElements);
        $this->assertEquals('auth:Description', $claimTypeElements[0]->tagName);
        $this->assertEquals('auth:DisplayValue', $claimTypeElements[1]->tagName);
        $this->assertEquals('auth:Value', $claimTypeElements[2]->tagName);
    }
}
