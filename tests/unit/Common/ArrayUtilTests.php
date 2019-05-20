<?php declare(strict_types=1);

namespace UnitTests\Common;

use PHPUnit\Framework\TestCase;
use Stellar\Common\ArrayUtil;

/**
 * @coversDefaultClass \Stellar\Common\ArrayUtil
 */
class ArrayUtilTests extends TestCase
{
    use ArrayUtilTestsProvider;

    /**
     * @covers ::merge()
     */
    public function test_merge_empty_arrays()
    {
        $this->assertSame([], ArrayUtil::merge([]));
        $this->assertSame([], ArrayUtil::merge([], []));
        $this->assertSame([], ArrayUtil::merge([], [], []));
    }

    /**
     * @covers ::merge()
     */
    public function test_merge_arrays_with_indexes()
    {
        $this->assertSame([ 1, 2 ], ArrayUtil::merge([ 0, 1 ], [ 1, 2 ]));
        $this->assertSame([ 2, 3, 4 ], ArrayUtil::merge([ 0, 1, 4 ], [ 2, 3 ]));
    }

    public function test_merge()
    {
        $this->assertSame([ 'a' ], ArrayUtil::merge([ 'a' ]));
        $this->assertSame([ 'a' => 1 ], ArrayUtil::merge([ 'a' => 1 ]));
    }

    /**
     * @covers ::merge()
     */
    public function test_merge_with_empty_arrays()
    {
        $this->assertSame([ 'a' => 1 ], ArrayUtil::merge([], [ 'a' => 1 ]));
        $this->assertSame([ 'a' => 1, 0 => 'b' ], ArrayUtil::merge([ 'a' => 1 ], [], [ 'b' ]));
    }

    /**
     * @covers ::merge()
     */
    public function test_merge_with_duplicate_keys()
    {
        $this->assertSame([ 'a' => 1, 'b' => 3, 'c' => 2 ], ArrayUtil::merge(
            [ 'a' => 1 ],
            [ 'b' => 2 ],
            [ 'c' => 2, 'b' => 3 ]
        ));
    }

    /**
     * @covers ::join()
     */
    public function test_join_empty_key()
    {
        $this->assertSame([ '' => '=baz' ], ArrayUtil::join('=', [ '' => 'baz' ]));
        $this->assertSame([ '' => 'baz' ], ArrayUtil::join('', [ '' => 'baz' ]));
    }

    /**
     * @covers ::join()
     */
    public function test_join_empty_value()
    {
        $this->assertSame([ 'bar' => 'bar' ], ArrayUtil::join('', [ 'bar' => '' ]));
        $this->assertSame([ 'bar' => 'bar;' ], ArrayUtil::join(';', [ 'bar' => '' ]));
    }

    /**
     * @covers ::join()
     */
    public function test_join_empty_key_and_value()
    {
        $this->assertSame([], ArrayUtil::join('??', [ '' => '' ]));
        $this->assertSame([ '' => '' ], ArrayUtil::join('??', [ '' => '' ], false));
    }

    /**
     * @covers ::join()
     */
    public function test_join_key_and_value()
    {
        $this->assertSame([ 'foo' => 'foo=bar' ], ArrayUtil::join('=', [ 'foo' => 'bar' ]));
        $this->assertSame([ 'foo' => 'foobar' ], ArrayUtil::join('', [ 'foo' => 'bar' ]));
    }

    /**
     * @covers ::joinFormat()
     */
    public function test_joinFormat_without_format_vars()
    {
        $input = [ 'test' => 'value' ];
        $this->assertSame($input, ArrayUtil::joinFormat('the format does not have any vars', $input));
    }

    /**
     * @covers ::joinFormat()
     */
    public function test_joinFormat_with_empty_values()
    {
        $this->assertSame([], ArrayUtil::joinFormat('%k%v', []));
        $this->assertSame([], ArrayUtil::joinFormat('%k%v', [ '' => '' ]));
        $this->assertSame([ '' => '' ], ArrayUtil::joinFormat('%k%v', [ '' => '' ], false));
    }

    /**
     * @covers ::joinFormat()
     */
    public function test_joinFormat_with_single_entry()
    {
        $this->assertSame([ 'foo' => '0' ], ArrayUtil::joinFormat('%i', [ 'foo' => 'bar' ]));
        $this->assertSame([ 'foo' => 'foo' ], ArrayUtil::joinFormat('%k', [ 'foo' => 'bar' ]));
        $this->assertSame([ 'foo' => 'bar' ], ArrayUtil::joinFormat('%v', [ 'foo' => 'bar' ]));
        $this->assertSame([ 'foo' => 'foobar' ], ArrayUtil::joinFormat('%k%v', [ 'foo' => 'bar' ]));
        $this->assertSame([ 'foo' => '#0: foobar' ], ArrayUtil::joinFormat('#%i: %k%v', [ 'foo' => 'bar' ]));
    }

    /**
     * @covers ::joinFormat()
     */
    public function test_joinFormat_with_list()
    {
        $this->assertSame(
            [
                0   => '#0 0: foo',
                2   => '#1 2: bar',
                '3' => '#2 3: baz',
            ],
            ArrayUtil::joinFormat('#%i %k: %v', [
                0   => 'foo',
                2   => 'bar',
                '3' => 'baz',
            ])
        );
    }

    /**
     * @covers ::flatten()
     */
    public function test_flatten()
    {
        $array = [
            1   => 1,
            3   => [ 2, 'a', 'b' ],
            '2' => [
                'z' => [ [ 'foo' ] ],
            ],
        ];

        $this->assertSame([ 1, 2, 'a', 'b', 'foo' ], ArrayUtil::flatten($array));
    }

    /**
     * @covers ::flatten()
     */
    public function test_flatten_with_low_depth()
    {
        $array = [
            1   => 1,
            3   => [ 2, 'a', 'b' ],
            '2' => [
                'z' => [ [ 'foo' ] ],
            ],
        ];

        $this->assertSame([ 1, 2, 'a', 'b', [ [ 'foo' ] ] ], ArrayUtil::flatten($array, 1));
    }

    /**
     * @covers ::flatten()
     */
    public function test_flatten_with_max_depth_set()
    {
        $array = [
            1   => 1,
            3   => [ 2, 'a', 'b' ],
            '2' => [
                'z' => [ [ 'foo' ] ],
            ],
        ];

        $this->assertSame([ 1, 2, 'a', 'b', [ 'foo' ] ], ArrayUtil::flatten($array, 2));
    }

    /**
     * @covers ::flattenKeys()
     * @dataProvider flattenKeysDataProvider()
     */
    public function test_flattenKeys(array $expected, ... $args)
    {
        $this->assertSame($expected, ArrayUtil::flattenKeys(... $args));
    }

    /**
     * @covers ::withKeys()
     */
    public function test_withKeys()
    {
        $array = [
            'foo' => 'foo value',
            'bar' => 'bar value',
        ];

        $this->assertSame($array, ArrayUtil::withKeys($array, 'bar', 'foo'));
        $this->assertSame([ 'foo' => 'foo value' ], ArrayUtil::withKeys($array, 'foo'));
        $this->assertSame([ 'foo' => 'foo value' ], ArrayUtil::withKeys($array, 'foo', 'baz'));
        $this->assertSame([], ArrayUtil::withKeys($array));
    }

    public function test_withKeys_with_empty_array() {
        $this->assertSame([], ArrayUtil::withKeys([], 'foo', 'bar'));
    }

    /**
     * @covers ::withoutKeys()
     */
    public function test_withoutKeys()
    {
        $array = [
            'foo' => 'foo value',
            'bar' => 'bar value',
        ];

        $this->assertSame($array, ArrayUtil::withoutKeys($array));
        $this->assertSame($array, ArrayUtil::withoutKeys($array, 'baz'));
        $this->assertSame([ 'bar' => 'bar value' ], ArrayUtil::withoutKeys($array, 'foo'));
        $this->assertSame([ 'foo' => 'foo value' ], ArrayUtil::withoutKeys($array, 'bar', 'baz'));
        $this->assertSame([], ArrayUtil::withoutKeys($array, 'bar', 'foo'));
    }

    /**
     * @covers ::wrap()
     */
    public function test_wrap()
    {
        $expected = [ 'foo', 'bar' ];
        $this->assertSame($expected, ArrayUtil::wrap($expected));
        $this->assertSame([ $expected ], ArrayUtil::wrap([ $expected ]));
        $this->assertSame([], ArrayUtil::wrap([]));
        $this->assertSame([ 'baz' ], ArrayUtil::wrap('baz'));
        $this->assertSame([ true ], ArrayUtil::wrap(true));
    }

    /**
     * @covers ::unwrap()
     */
    public function test_unwrap()
    {
        $expected = [ 'foo', 'bar' ];
        $this->assertSame($expected, ArrayUtil::unwrap($expected));
        $this->assertSame([ $expected ], ArrayUtil::unwrap([ [ $expected ] ]));
        $this->assertSame([], ArrayUtil::unwrap([]));
        $this->assertSame('baz', ArrayUtil::unwrap([ 'baz' ]));
        $this->assertTrue(ArrayUtil::unwrap([ true ]));
        $this->assertNull(ArrayUtil::unwrap([ null ]));
    }
}

trait ArrayUtilTestsProvider
{
    public static function flattenKeysDataProvider() : array
    {
        return [
            [
                [ 'foo' => 'bar' ],
                [ 'foo' => 'bar' ],
            ],

            [
                [ 'foo.0' => 'bar' ],
                [ 'foo' => [ 'bar' ] ],
            ],

            [
                [ 'foo.0.0' => 'bar' ],
                [ 'foo' => [ [ 'bar' ] ] ],
            ],

            [
                [ 'foo' => [ 'bar' ] ],
                [ 'foo' => [ 'bar' ] ],
                '-',
                0,
            ],

            [
                [ 'foox0' => [ 'bar' ] ],
                [ 'foo' => [ [ 'bar' ] ] ],
                'x',
                1,
            ],

            [
                [ 'foo.bar' => 'baz' ],
                [ 'foo' => [ 'bar' => 'baz' ] ],
            ],

            [
                [ 'path/to/file' => 'someFile.ext' ],
                [ 'path' => [ 'to' => [ 'file' => 'someFile.ext' ] ] ],
                '/',
            ],

            [
                [ 'path/to/file' => [ 'someFile.ext' ] ],
                [ 'path' => [ 'to' => [ 'file' => [ 'someFile.ext' ] ] ] ],
                '/',
                2,
            ],
        ];
    }
}
