<?php

declare(strict_types=1);

namespace SimpleSAML\WebServices\Federation\XML\fed;

use DOMElement;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Type\StringValue;
use SimpleSAML\XMLSchema\XML\Constants\NS;

/**
 * An AbstractAttributeExtensibleString element
 *
 * @package simplesamlphp/xml-ws-federation
 */
abstract class AbstractAttributeExtensibleString extends AbstractFedElement
{
    use ExtendableAttributesTrait;
    use TypedTextContentTrait;


    /** The namespace-attribute for the xs:anyAttribute element */
    public const string XS_ANY_ATTR_NAMESPACE = NS::OTHER;

    public const string TEXTCONTENT_TYPE = StringValue::class;


    /**
     * @param \SimpleSAML\XMLSchema\Type\StringValue $content
     * @param \SimpleSAML\XML\Attribute[] $namespacedAttributes
     */
    public function __construct(StringValue $content, array $namespacedAttributes = [])
    {
        $this->setContent($content);
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Create XML from this class
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);
        $e->textContent = $this->getContent()->getValue();

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        return $e;
    }
}
