<?php

declare(strict_types=1);

namespace SimpleSAML\Test\WebServices\Federation\XML\auth;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\WebServices\Federation\XML\auth\AbstractAuthElement;
use SimpleSAML\WebServices\Federation\XML\auth\AbstractConstrainedManyValueType;
use SimpleSAML\WebServices\Federation\XML\auth\StructuredValue;
use SimpleSAML\WebServices\Federation\XML\auth\Value;
use SimpleSAML\WebServices\Federation\XML\auth\ValueOneOf;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Chunk;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XMLSchema\Type\StringValue;

/**
 * Tests for auth:ConstrainedManyValueType.
 *
 * @package simplesamlphp/xml-ws-federation
 */
#[Group('auth')]
#[CoversClass(StructuredValue::class)]
#[CoversClass(ValueOneOf::class)]
#[CoversClass(AbstractConstrainedManyValueType::class)]
#[CoversClass(AbstractAuthElement::class)]
final class ConstrainedManyValueTest extends TestCase
{
    /**
     * Test creating an object from scratch.
     *
     * @param class-string $class
     */
    #[DataProvider('classProvider')]
    public function testMarshallingEmpty(string $class): void
    {
        /** @var \SimpleSAML\XML\SerializableElementInterface $x */
        $x = new $class([], []);
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
        new $class([$value], [$structuredValue]);
    }


    /**
     * @return array<string, array<string>>
     */
    public static function classProvider(): array
    {
        return [
            'auth:ValueOneOf' => [ValueOneOf::class],
        ];
    }
}
