<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WebServices\Federation\Constants as C;
use SimpleSAML\WebServices\Federation\XML\auth\ClaimType;
use SimpleSAML\WebServices\Federation\XML\auth\Description;
use SimpleSAML\WebServices\Federation\XML\auth\DisplayName;
use SimpleSAML\WebServices\Federation\XML\auth\DisplayValue;
use SimpleSAML\WebServices\Federation\XML\auth\Value;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractClaimTypesOfferedType;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractFedElement;
use SimpleSAML\WebServices\Federation\XML\fed\ClaimTypesOffered;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\BooleanValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;

/**
 * Class \SimpleSAML\WebServices\Federation\XML\fed\ClaimTypesOfferedTest
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('fed')]
#[CoversClass(ClaimTypesOffered::class)]
#[CoversClass(AbstractClaimTypesOfferedType::class)]
#[CoversClass(AbstractFedElement::class)]
final class ClaimTypesOfferedTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = ClaimTypesOffered::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed/ClaimTypesOffered.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a PPID object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr2', StringValue::fromString('testval2'));

        $claimType = new ClaimType(
            AnyURIValue::fromString(C::NAMESPACE),
            BooleanValue::fromBoolean(true),
            new DisplayName(StringValue::fromString('someDisplayName')),
            new Description(StringValue::fromString('someDescription')),
            new DisplayValue(StringValue::fromString('someDisplayValue')),
            new Value(StringValue::fromString('someValue')),
            [$attr2],
        );

        $claimTypesOffered = new ClaimTypesOffered([$claimType], [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($claimTypesOffered),
        );
    }
}
