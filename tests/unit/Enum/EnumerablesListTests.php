<?php declare(strict_types=1);

namespace UnitTests\Enum;

use PHPUnit\Framework\TestCase;
use Stellar\Enum\EnumerablesList;

/**
 * @coversDefaultClass \Stellar\Enum\EnumerablesList
 */
class EnumerablesListTests extends TestCase
{
    public function test_getList_without_custom_values()
    {
        $this->assertSame([
            'FOO' => 'foo',
            'BAR' => 'bar',
            'BAZ' => 'baz',
            'FOZ' => 'foz',
        ], (new EnumerablesList(EnumFixture::class))->getList());
    }

    public function test_getList_with_custom_values()
    {
        $actual = (new EnumerablesList(CustomValuesFixture::class, [
            CustomValuesFixture::FOO => 'foo',
            CustomValuesFixture::BAR => 'bar',
            CustomValuesFixture::BAZ => 'baz',
            CustomValuesFixture::FOZ => 'foz',
        ]))->getList();

        $this->assertSame([
            'FOO' => 'foo',
            'BAR' => 'bar',
            'BAZ' => 'baz',
            'FOZ' => 'foz',
        ], $actual);
    }

    public function test_toArray_without_custom_values()
    {
        $this->assertSame([
            'UnitTests\Enum\EnumFixture::FOO' => 'foo',
            'UnitTests\Enum\EnumFixture::BAR' => 'bar',
            'UnitTests\Enum\EnumFixture::BAZ' => 'baz',
            'UnitTests\Enum\EnumFixture::FOZ' => 'foz',
        ], (new EnumerablesList(EnumFixture::class))->toArray());
    }

    public function test_toArray_with_custom_values()
    {
        $actual = (new EnumerablesList(CustomValuesFixture::class, [
            CustomValuesFixture::FOO => 'f00',
            CustomValuesFixture::BAR => 'b4r',
            CustomValuesFixture::BAZ => '8az',
            CustomValuesFixture::FOZ => 123,
        ]))->toArray();

        $this->assertSame([
            'UnitTests\Enum\CustomValuesFixture::FOO' => 'f00',
            'UnitTests\Enum\CustomValuesFixture::BAR' => 'b4r',
            'UnitTests\Enum\CustomValuesFixture::BAZ' => '8az',
            'UnitTests\Enum\CustomValuesFixture::FOZ' => 123,
        ], $actual);
    }
}
