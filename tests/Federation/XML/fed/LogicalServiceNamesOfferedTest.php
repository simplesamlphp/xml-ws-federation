<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractFedElement;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractLogicalServiceNamesOfferedType;
use SimpleSAML\WebServices\Federation\XML\fed\IssuerName;
use SimpleSAML\WebServices\Federation\XML\fed\LogicalServiceNamesOffered;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;
use function strval;

/**
 * Tests for fed:LogicalServiceNamesOffered.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('fed')]
#[CoversClass(LogicalServiceNamesOffered::class)]
#[CoversClass(AbstractLogicalServiceNamesOfferedType::class)]
#[CoversClass(AbstractFedElement::class)]
final class LogicalServiceNamesOfferedTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = LogicalServiceNamesOffered::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed/LogicalServiceNamesOffered.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a LogicalServiceNamesOffered object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $attr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', StringValue::fromString('testval2'));

        $issuerName = new IssuerName(
            AnyURIValue::fromString('urn:some:uri'),
            [$attr2],
        );

        $logicalServiceNamesOffered = new LogicalServiceNamesOffered(
            [$issuerName],
            [$attr1],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($logicalServiceNamesOffered),
        );
    }
}
