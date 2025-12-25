<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Federation\Constants as C;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractFedElement;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractFilterPseudonymsType;
use SimpleSAML\WebServices\Federation\XML\fed\FilterPseudonyms;
use SimpleSAML\WebServices\Federation\XML\fed\PseudonymBasis;
use SimpleSAML\WebServices\Federation\XML\fed\RelativeTo;
use SimpleSAML\WebServices\SecurityPolicy\XML\sp_200702\NoPassword;
use SimpleSAML\XML\Attribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for fed:FilterPseudonyms.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('fed')]
#[CoversClass(FilterPseudonyms::class)]
#[CoversClass(AbstractFilterPseudonymsType::class)]
#[CoversClass(AbstractFedElement::class)]
final class FilterPseudonymsTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /** @var \SimpleSAML\XML\Chunk $chunk */
    protected static Chunk $chunk;

    /** @var \SimpleSAML\XML\Chunk $basis */
    protected static Chunk $basis;

    /** @var \SimpleSAML\XML\Chunk $relative */
    protected static Chunk $relative;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = FilterPseudonyms::class;

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed/FilterPseudonyms.xml',
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
    }


    // test marshalling


    /**
     * Adding an empty FilterPseudonyms element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $fedns = C::NS_FED;
        $filterPseudonyms = new FilterPseudonyms();
        $this->assertEquals(
            "<fed:FilterPseudonyms xmlns:fed=\"$fedns\"/>",
            strval($filterPseudonyms),
        );
        $this->assertTrue($filterPseudonyms->isEmptyElement());
    }


    /**
     * Test creating an FilterPseudonyms object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', StringValue::fromString('testval2'));
        $attr3 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr3', StringValue::fromString('testval3'));
        $attr4 = new Attribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr4', StringValue::fromString('testval4'));

        $pseudonymBasis = new PseudonymBasis(
            self::$basis,
            [$attr2],
        );

        $relativeTo = new RelativeTo(
            [self::$relative],
            [$attr3],
        );

        $noPassword = new NoPassword([$attr4]);
        $filterPseudonyms = new FilterPseudonyms(
            $pseudonymBasis,
            $relativeTo,
            [$noPassword],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($filterPseudonyms),
        );
    }
}
