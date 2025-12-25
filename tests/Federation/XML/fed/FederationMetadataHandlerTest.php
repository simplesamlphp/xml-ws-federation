<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WebServices\Federation\Constants as C;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractFedElement;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractFederationMetadataHandlerType;
use SimpleSAML\WebServices\Federation\XML\fed\FederationMetadataHandler;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;

/**
 * Class \SimpleSAML\WebServices\Federation\XML\fed\FederationMetadataHandlerTest
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('fed')]
#[CoversClass(FederationMetadataHandler::class)]
#[CoversClass(AbstractFederationMetadataHandlerType::class)]
#[CoversClass(AbstractFedElement::class)]
final class FederationMetadataHandlerTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = FederationMetadataHandler::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed/FederationMetadataHandler.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a FederationMetadataHandler object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('testval1'));
        $federationMetadataHandler = new FederationMetadataHandler([$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($federationMetadataHandler),
        );
    }


    /**
     */
    public function testMarshallingEmpty(): void
    {
        $federationMetadataHandler = new FederationMetadataHandler();
        $this->assertTrue($federationMetadataHandler->isEmptyElement());
    }
}
