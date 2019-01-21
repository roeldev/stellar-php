<?php declare(strict_types=1);

namespace UnitTests\Encoding;

use Faker\Factory as FakerFactory;
use Stellar\Encoding\Base32;

class Base32TestsData
{
    public static function variants() : array
    {
        return [
            new Base32\Base32Hex(),
            new Base32\Crockford(),
            new Base32\Rfc4648(),
            new Base32\ZBase32(),
        ];
    }

    public function encodedData() : array
    {
        return [
            [ '', '' ],
            [ 'MZXW6YTBOJRGC6Q=', 'foobarbaz' ],
            [ 'MZXW6YTBOJRGC6Q', 'foobarbaz', null, false ],
            [ 'MNXXMZTFMZSQ====', 'covfefe', new Base32\Rfc4648() ],
            [ 'MNXXMZTFMZSQ', 'covfefe', new Base32\Rfc4648(), false ],

            [
                'ELPMIRJ741Q6GP90DTM68PBI41H62SR56CP6GPBO',
                'using the older base32hex',
                new Base32\Base32Hex(),
            ],
            [
                'ELPMIRJ741Q6GP90DTM68PBI41H62SR56CP6GPBO5GG6SRRN41RMIT3841O62P34D5N6E===',
                'using the older base32hex, now with padding',
                new Base32\Base32Hex(),
            ],
            [
                'CHQPWS90EXMQ8T10CDS6YRVBCSQQ4S17ECG62V3GD1GP4SBM',
                'done with crockford\'s alphabet',
                new Base32\Crockford(),
            ],
            [
                'CDS6YRVBCSQQ4S17ECG62V3GD1GP4SBM41VPJX3841R62S34D5Q6E===',
                'crockford\'s alphabet with padding',
                new Base32\Crockford(),
            ],
            [
                'cizgg55rci1ny75jqtwny6tpcjozg3jugeo8q4djcpwnyau3rb1gk3ubqis8eedecf31y5uxrbagn3drpfzgq',
                'encoded with z-base32 which by default has no padding',
                new Base32\ZBase32(),
            ],
        ];
    }

    public function randomData() : array
    {
        $faker = FakerFactory::create();

        return [
            [ $faker->text ],
            [ $faker->name ],
            [ $faker->address ],
            [ (string) $faker->randomNumber() ],
            [ 'Mr. Demarcus O\'Reilly PhD' ],
            [ 'Meghan Douglas DVM' ],
            [ 'Lindsay Schultz' ],
        ];
    }
}
