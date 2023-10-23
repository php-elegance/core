<?php

use Elegance\Log;

if (!function_exists('_log')) {

    /** adiciona uma linha ao log */
    function _log($message, ?string $ref = null): void
    {
        Log::line('info', $message, $ref);
    }
}

if (!function_exists('_logSection')) {

    /** adiciona uma linha ao log */
    function _logSection(?string $message = null, ?string $ref = null): void
    {
        Log::section($message, $ref);
    }
}
