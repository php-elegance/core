<?php

namespace Elegance;

abstract class Log
{
    private static array $autoload = [];

    protected static array $lines = [];
    protected static int $section = 0;

    /** Inicia o registro de log */
    static function __start(): void
    {
        if (!self::started() && env('DEV')) {
            self::$autoload = spl_autoload_functions();
            array_map(fn ($v) => spl_autoload_unregister($v), self::$autoload);
            spl_autoload_register(fn ($className) => self::line('class', "load", $className));
            array_map(fn ($v) => spl_autoload_register($v), self::$autoload);
        }
    }

    /** Finaliza o registro de log */
    static function __close(): void
    {
        if (self::started() && env('DEV')) {
            array_map(fn ($v) => spl_autoload_unregister($v), spl_autoload_functions());
            array_map(fn ($v) => spl_autoload_register($v), self::$autoload);
            self::$lines = [];
            self::$autoload = [];
            self::$section = 0;
        }
    }

    static function getLines(): string
    {
        while (self::$section)
            self::section();

        $lines = self::$lines;

        self::__close();

        return implode("\n", $lines);
    }

    protected static function started(): bool
    {
        return !empty(self::$autoload);
    }

    static function line($type, $message, ?string $ref = null)
    {
        if (self::started()) {
            $message = $ref ? "$type:$message [$ref]" : "$type:$message";
            self::$lines[] =  str_repeat('|', self::$section) . "$message";
        }
    }

    static function section(?string $message = null, ?string $ref = null)
    {
        if ($message) {
            self::line('sectionOpen', $message, $ref);
            self::$section++;
        } else {
            self::$section--;
            if (str_starts_with(end(self::$lines), str_repeat('|', self::$section) . 'sectionOpen:')) {
                list($type, $message) = explode(':', array_pop(self::$lines) . '');
                self::line('info', $message);
            } else {
                self::line('sctionClose', $ref);
            }
        }
    }
}
