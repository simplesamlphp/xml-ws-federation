<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractFedElement;
use SimpleSAML\WebServices\Federation\XML\fed\AutomaticPseudonyms;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Type\BooleanValue;

use function dirname;

/**
 * Class \SimpleSAML\WebServices\Federation\XML\fed\AutomaticPseudonymsTest
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('fed')]
#[CoversClass(AutomaticPseudonyms::class)]
#[CoversClass(AbstractFedElement::class)]
final class AutomaticPseudonymsTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = AutomaticPseudonyms::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed/AutomaticPseudonyms.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a AutomaticPseudonyms object from scratch.
     */
    public function testMarshalling(): void
    {
        $automaticPseudonyms = new AutomaticPseudonyms(BooleanValue::fromBoolean(true));

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($automaticPseudonyms),
        );
    }
}
