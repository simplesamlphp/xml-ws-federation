<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\fed;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\SAML2\Type\SAMLAnyURIListValue;
use SimpleSAML\SAML2\Type\SAMLStringValue;
use SimpleSAML\WebServices\Addressing\XML\wsa_200508\Address;
use SimpleSAML\WebServices\Addressing\XML\wsa_200508\EndpointReference;
use SimpleSAML\WebServices\Federation\Constants as C;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractSecurityTokenServiceType;
use SimpleSAML\WebServices\Federation\XML\fed\AbstractWebServiceDescriptorType;
use SimpleSAML\WebServices\Federation\XML\fed\PassiveRequestorEndpoint;
use SimpleSAML\WebServices\Federation\XML\fed\SecurityTokenServiceEndpoint;
use SimpleSAML\WebServices\Federation\XML\fed\SecurityTokenServiceType;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XMLSchema\Constants as C_XSI;
use SimpleSAML\XMLSchema\Type\AnyURIValue;
use SimpleSAML\XMLSchema\Type\NCNameValue;
use SimpleSAML\XMLSchema\Type\QNameValue;

use function dirname;
use function strval;

/**
 * Tests for fed:SecurityTokenServiceType.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('fed')]
#[CoversClass(SecurityTokenServiceType::class)]
#[CoversClass(AbstractSecurityTokenServiceType::class)]
#[CoversClass(AbstractWebServiceDescriptorType::class)]
final class SecurityTokenServiceTypeTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = SecurityTokenServiceType::class;

        self::$xmlRepresentation = DOMDocumentFactory::FromFile(
            dirname(__FILE__, 4) . '/resources/xml/fed/SecurityTokenServiceType.xml',
        );
    }


    /**
     * Build the object used by the tests below.
     */
    private static function buildSecurityTokenServiceType(): SecurityTokenServiceType
    {
        return new SecurityTokenServiceType(
            QNameValue::fromParts(
                NCNameValue::fromString(AbstractSecurityTokenServiceType::XSI_TYPE_NAME),
                AnyURIValue::fromString(AbstractSecurityTokenServiceType::XSI_TYPE_NAMESPACE),
                NCNameValue::fromString(AbstractSecurityTokenServiceType::XSI_TYPE_PREFIX),
            ),
            SAMLAnyURIListValue::fromString(C::NS_FED),
            serviceDisplayName: SAMLStringValue::fromString('SimpleSAMLphp ADFS IdP'),
            securityTokenServiceEndpoint: [
                new SecurityTokenServiceEndpoint([
                    new EndpointReference(
                        new Address(AnyURIValue::fromString('https://idp.example.org/adfs/services/trust')),
                    ),
                ]),
            ],
            passiveRequestorEndpoint: [
                new PassiveRequestorEndpoint([
                    new EndpointReference(
                        new Address(AnyURIValue::fromString('https://idp.example.org/adfs/ls/')),
                    ),
                ]),
            ],
        );
    }


    // test marshalling


    /**
     * Test creating a SecurityTokenServiceType object from scratch.
     */
    public function testMarshalling(): void
    {
        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval(self::buildSecurityTokenServiceType()),
        );
    }


    /**
     * md:RoleDescriptor carries its element type in xsi:type, and AbstractRoleDescriptor::fromXML()
     * rejects the element outright when it is absent. Serialising has to emit it.
     */
    public function testMarshallingWritesXsiType(): void
    {
        $element = self::buildSecurityTokenServiceType()->toXML();

        $this->assertEquals(
            'fed:SecurityTokenServiceType',
            $element->getAttributeNS(C_XSI::NS_XSI, 'type'),
        );

        // The prefix used inside the attribute value only counts if it is bound on the element.
        $this->assertEquals(C::NS_FED, $element->lookupNamespaceURI('fed'));
    }


    /**
     * The element must be able to read back what it writes. Before the xsi:type was emitted this threw
     * a SchemaViolationException on the object's own output.
     */
    public function testRoundTrip(): void
    {
        $original = self::buildSecurityTokenServiceType();

        $this->assertEquals(
            strval($original),
            strval(SecurityTokenServiceType::fromXML($original->toXML())),
        );
    }


    /**
     * An xsi:type may legally be unprefixed, resolving through the document's default namespace. The
     * element must not lose that namespace on the way out — a default namespace cannot be re-declared
     * here without capturing unqualified descendants, so the type is re-expressed with its own prefix.
     */
    public function testUnprefixedXsiTypeKeepsItsNamespace(): void
    {
        $xml = <<<XML
        <md:RoleDescriptor xmlns:md="urn:oasis:names:tc:SAML:2.0:metadata"
                           xmlns="http://docs.oasis-open.org/wsfed/federation/200706"
                           xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                           xmlns:wsa10="http://www.w3.org/2005/08/addressing"
                           xsi:type="SecurityTokenServiceType"
                           protocolSupportEnumeration="http://docs.oasis-open.org/wsfed/federation/200706">
          <SecurityTokenServiceEndpoint>
            <wsa10:EndpointReference>
              <wsa10:Address>https://idp.example.org/adfs/services/trust</wsa10:Address>
            </wsa10:EndpointReference>
          </SecurityTokenServiceEndpoint>
        </md:RoleDescriptor>
        XML;

        $parsed = SecurityTokenServiceType::fromXML(
            DOMDocumentFactory::fromString($xml)->documentElement,
        );
        $this->assertNull($parsed->getXsiType()->getNamespacePrefix());

        $element = $parsed->toXML();
        $this->assertEquals(
            'fed:SecurityTokenServiceType',
            $element->getAttributeNS(C_XSI::NS_XSI, 'type'),
        );

        // No default namespace may be introduced, or unqualified descendants would change meaning.
        $this->assertNull($element->lookupNamespaceURI(null));

        // What matters is that the QName still denotes the same {namespace, local name}.
        $this->assertEquals(
            C::NS_FED,
            SecurityTokenServiceType::fromXML($element)->getXsiType()->getNamespaceURI()->getValue(),
        );
    }


    // test unmarshalling


    /**
     * Test creating a SecurityTokenServiceType object from XML.
     */
    public function testUnmarshalling(): void
    {
        $securityTokenServiceType = SecurityTokenServiceType::fromXML(
            self::$xmlRepresentation->documentElement,
        );

        $this->assertEquals(
            'fed:SecurityTokenServiceType',
            strval($securityTokenServiceType->getXsiType()),
        );

        // xsi:type is modelled as the element's own type, not as one of its extendable attributes.
        $this->assertEmpty($securityTokenServiceType->getAttributesNS());
        $this->assertCount(1, $securityTokenServiceType->getSecurityTokenServiceEndpoint());
        $this->assertCount(1, $securityTokenServiceType->getPassiveRequestorEndpoint());
        $this->assertEquals(
            'SimpleSAMLphp ADFS IdP',
            strval($securityTokenServiceType->getServiceDisplayName()),
        );
    }
}
