<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\auth;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WebServices\Federation\XML\auth\AbstractAuthElement;
use SimpleSAML\WebServices\Federation\XML\auth\AbstractConstrainedSingleValueType;
use SimpleSAML\WebServices\Federation\XML\auth\StructuredValue;
use SimpleSAML\WebServices\Federation\XML\auth\Value;
use SimpleSAML\WebServices\Federation\XML\auth\ValueGreaterThan;
use SimpleSAML\WebServices\Federation\XML\auth\ValueGreaterThanOrEqual;
use SimpleSAML\WebServices\Federation\XML\auth\ValueLessThan;
use SimpleSAML\WebServices\Federation\XML\auth\ValueLessThanOrEqual;
use SimpleSAML\WebServices\Federation\XML\auth\ValueLowerBound;
use SimpleSAML\WebServices\Federation\XML\auth\ValueUpperBound;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XMLSchema\Type\StringValue;

/**
 * Tests for auth:ConstrainedSingleValueType.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('auth')]
#[CoversClass(ValueGreaterThan::class)]
#[CoversClass(ValueGreaterThanOrEqual::class)]
#[CoversClass(ValueLessThan::class)]
#[CoversClass(ValueLessThanOrEqual::class)]
#[CoversClass(ValueLowerBound::class)]
#[CoversClass(ValueUpperBound::class)]
#[CoversClass(AbstractConstrainedSingleValueType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class ConstrainedSingleValueTest extends TestCase
{
    /**
     * Test creating an object from scratch.
     *
     * @param class-string $class
     */
    #[DataProvider('classProvider')]
    public function testMarshallingEmpty(string $class): void
    {
        $x = new $class(null, null);
        $this->assertTrue($x->isEmptyElement());
    }


    /**
     * Test creating an object from scratch with both Value and StructuredValue.
     *
     * @param class-string $class
     */
    #[DataProvider('classProvider')]
    public function testMarshallingIllegalCombination(string $class): void
    {
        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('testval1'));
        $child = DOMDocumentFactory::fromString(
            '<ssp:Chunk xmlns:ssp="urn:x-simplesamlphp:namespace">SomeChunk</ssp:Chunk>',
        );

        $structuredValue = new StructuredValue(
            [new Chunk($child->documentElement)],
            [$attr1],
        );

        $value = new Value(StringValue::fromString('MyValue'));

        $this->expectException(AssertionFailedException::class);
        new $class($value, $structuredValue);
    }


    /**
     */
    public static function classProvider(): array
    {
        return [
            'auth:ValueUpperBound' => [ValueUpperBound::class],
            'auth:ValueLowerBound' => [ValueLowerBound::class],
            'auth:ValueLessThan' => [ValueLessThan::class],
            'auth:ValueLessThanOrEqual' => [ValueLessThanOrEqual::class],
            'auth:ValueGreaterThan' => [ValueGreaterThan::class],
            'auth:ValueGreaterThanOrEqual' => [ValueGreaterThanOrEqual::class],
        ];
    }
}
