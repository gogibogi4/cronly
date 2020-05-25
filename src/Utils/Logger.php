<?php

namespace Cronly\Utils;

use League\CLImate\CLImate;

class Logger
{
    /**
     * @param int $level
     * @param string $message
     */
    public static function logMessage(int $level, string $message): void
    {
        $ident = '';

        while ($level !== 0) {
            $ident .= '  ';

            $level--;
        }

        (new CLImate())->bold(sprintf('%s: %s%s',date('Y-m-d H:i:s') , $ident, $message));
    }
}