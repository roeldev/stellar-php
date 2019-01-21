<?php declare(strict_types=1);

namespace Stellar\Debug;

class Debug
{
    private const FILE = __DIR__ . '/../../debug.log';

    public static function reset()
    {
        \file_put_contents(self::FILE, '');
    }

    public static function dump(... $vars)
    {
        \ob_start();
        \var_dump(... $vars);
        $dump = \ob_get_clean();

        $firstLine = strstr($dump, \PHP_EOL, true);
        $padding = \str_pad('', \strlen($firstLine), '=');

        $dump = \str_replace($firstLine, '', $dump);
        $dump = $padding . \PHP_EOL . $firstLine . \PHP_EOL . $padding . $dump . \PHP_EOL;

        \file_put_contents(self::FILE, $dump, FILE_APPEND);
    }
}
