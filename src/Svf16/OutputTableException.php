<?php

declare(strict_types=1);

namespace App\Svf16;

class OutputTableException extends \Exception
{
    public static function emptyData(): self
    {
        return new self('Table is empty');
    }

    public static function wrongDataCount(): self
    {
        return new self('Header row count does not equal data row count');
    }
}
