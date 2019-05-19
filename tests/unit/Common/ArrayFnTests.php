<?php declare(strict_types=1);

namespace UnitTests\Common;

use PHPUnit\Framework\TestCase;
use Stellar\Common\Arr;

/**
 * @coversDefaultClass \Stellar\Common\Arr
 */
class ArrayFnTests extends TestCase
{
    use ArrayFnTestsProvider;

    /**
     * @covers ::merge()
     */
    public function test_merge_empty_arrays()
    {
        $this->assertSame([], Arr::merge([]));
        $this->assertSame([], Arr::merge([], []));
        $this->assertSame([], Arr::merge([], [], []));
    }

    /**
     * @covers ::merge()
     */
    public function test_merge_arrays_with_indexes()
    {
        $this->assertSame([ 1, 2 ], Arr::merge([ 0, 1 ], [ 1, 2 ]));
        $this->assertSame([ 2, 3, 4 ], Arr::merge([ 0, 1, 4 ], [ 2, 3 ]));
    }

    public function test_merge()
    {
        $this->assertSame([ 'a' ], Arr::merge([ 'a' ]));
        $this->assertSame([ 'a' => 1 ], Arr::merge([ 'a' => 1 ]));
    }

    /**
     * @covers ::merge()
     */
    public function test_merge_with_empty_arrays()
    {
        $this->assertSame([ 'a' => 1 ], Arr::merge([], [ 'a' => 1 ]));
        $this->assertSame([ 'a' => 1, 0 => 'b' ], Arr::merge([ 'a' => 1 ], [], [ 'b' ]));
    }

    /**
     * @covers ::merge()
     */
    public function test_merge_with_duplicate_keys()
    {
        $this->assertSame([ 'a' => 1, 'b' => 3, 'c' => 2 ], Arr::merge(
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
        $this->assertSame([ '' => '=baz' ], Arr::join('=', [ '' => 'baz' ]));
        $this->assertSame([ '' => 'baz' ], Arr::join('', [ '' => 'baz' ]));
    }

    /**
     * @covers ::join()
     */
    public function test_join_empty_value()
    {
        $this->assertSame([ 'bar' => 'bar' ], Arr::join('', [ 'bar' => '' ]));
        $this->assertSame([ 'bar' => 'bar;' ], Arr::join(';', [ 'bar' => '' ]));
    }

    /**
     * @covers ::join()
     */
    public function test_join_empty_key_and_value()
    {
        $this->assertSame([], Arr::join('??', [ '' => '' ]));
        $this->assertSame([ '' => '' ], Arr::join('??', [ '' => '' ], false));
    }

    /**
     * @covers ::join()
     */
    public function test_join_key_and_value()
    {
        $this->assertSame([ 'foo' => 'foo=bar' ], Arr::join('=', [ 'foo' => 'bar' ]));
        $this->assertSame([ 'foo' => 'foobar' ], Arr::join('', [ 'foo' => 'bar' ]));
    }

    /**
     * @covers ::joinFormat()
     */
    public function test_joinFormat_without_format_vars()
    {
        $input = [ 'test' => 'value' ];
        $this->assertSame($input, Arr::joinFormat('the format does not have any vars', $input));
    }

    /**
     * @covers ::joinFormat()
     */
    public function test_joinFormat_with_empty_values()
    {
        $this->assertSame([], Arr::joinFormat('%k%v', []));
        $this->assertSame([], Arr::joinFormat('%k%v', [ '' => '' ]));
        $this->assertSame([ '' => '' ], Arr::joinFormat('%k%v', [ '' => '' ], false));
    }

    /**
     * @covers ::joinFormat()
     */
    public function test_joinFormat_with_single_entry()
    {
        $this->assertSame([ 'foo' => '0' ], Arr::joinFormat('%i', [ 'foo' => 'bar' ]));
        $this->assertSame([ 'foo' => 'foo' ], Arr::joinFormat('%k', [ 'foo' => 'bar' ]));
        $this->assertSame([ 'foo' => 'bar' ], Arr::joinFormat('%v', [ 'foo' => 'bar' ]));
        $this->assertSame([ 'foo' => 'foobar' ], Arr::joinFormat('%k%v', [ 'foo' => 'bar' ]));
        $this->assertSame([ 'foo' => '#0: foobar' ], Arr::joinFormat('#%i: %k%v', [ 'foo' => 'bar' ]));
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
            Arr::joinFormat('#%i %k: %v', [
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

        $this->assertSame([ 1, 2, 'a', 'b', 'foo' ], Arr::flatten($array));
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

        $this->assertSame([ 1, 2, 'a', 'b', [ [ 'foo' ] ] ], Arr::flatten($array, 1));
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

        $this->assertSame([ 1, 2, 'a', 'b', [ 'foo' ] ], Arr::flatten($array, 2));
    }

    /**
     * @covers ::flattenKeys()
     * @dataProvider flattenKeysDataProvider()
     */
    public function test_flattenKeys(array $expected, ... $args)
    {
        $this->assertSame($expected, Arr::flattenKeys(... $args));
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

        $this->assertSame($array, Arr::withKeys($array, 'bar', 'foo'));
        $this->assertSame([ 'foo' => 'foo value' ], Arr::withKeys($array, 'foo'));
        $this->assertSame([ 'foo' => 'foo value' ], Arr::withKeys($array, 'foo', 'baz'));
        $this->assertSame([], Arr::withKeys($array));
    }

    public function test_withKeys_with_empty_array() {
        $this->assertSame([], Arr::withKeys([], 'foo', 'bar'));
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

        $this->assertSame($array, Arr::withoutKeys($array));
        $this->assertSame($array, Arr::withoutKeys($array, 'baz'));
        $this->assertSame([ 'bar' => 'bar value' ], Arr::withoutKeys($array, 'foo'));
        $this->assertSame([ 'foo' => 'foo value' ], Arr::withoutKeys($array, 'bar', 'baz'));
        $this->assertSame([], Arr::withoutKeys($array, 'bar', 'foo'));
    }

    /**
     * @covers ::wrap()
     */
    public function test_wrap()
    {
        $expected = [ 'foo', 'bar' ];
        $this->assertSame($expected, Arr::wrap($expected));
        $this->assertSame([ $expected ], Arr::wrap([ $expected ]));
        $this->assertSame([], Arr::wrap([]));
        $this->assertSame([ 'baz' ], Arr::wrap('baz'));
        $this->assertSame([ true ], Arr::wrap(true));
    }

    /**
     * @covers ::unwrap()
     */
    public function test_unwrap()
    {
        $expected = [ 'foo', 'bar' ];
        $this->assertSame($expected, Arr::unwrap($expected));
        $this->assertSame([ $expected ], Arr::unwrap([ [ $expected ] ]));
        $this->assertSame([], Arr::unwrap([]));
        $this->assertSame('baz', Arr::unwrap([ 'baz' ]));
        $this->assertTrue(Arr::unwrap([ true ]));
        $this->assertNull(Arr::unwrap([ null ]));
    }
}

trait ArrayFnTestsProvider
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
