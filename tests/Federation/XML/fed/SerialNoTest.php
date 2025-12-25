<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Test\WebServices\Federation\Constants as C;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractAttributeExtensibleString;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractAttributeExtensibleURI;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractFedElement;
use SimpleSAML\WebServices\Federation\XML\fed\SerialNo;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\StringValue;

use function dirname;

/**
 * Class \SimpleSAML\WebServices\Federation\XML\fed\SerialNoTest
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('fed')]
#[CoversClass(SerialNo::class)]
#[CoversClass(AbstractAttributeExtensibleURI::class)]
#[CoversClass(AbstractAttributeExtensibleString::class)]
#[CoversClass(AbstractFedElement::class)]
final class SerialNoTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = SerialNo::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed/SerialNo.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a SerialNo object from scratch.
     */
    public function testMarshalling(): void
    {
        $attr1 = new XMLAttribute(C::NAMESPACE, 'ssp', 'attr1', StringValue::fromString('testval1'));
        $serialNo = new SerialNo(AnyURIValue::fromString(C::NAMESPACE), [$attr1]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($serialNo),
        );
    }
}
