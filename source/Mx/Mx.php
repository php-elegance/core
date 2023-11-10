<?php

namespace Mx;

use Error;
use Exception;
use ReflectionMethod;

abstract class Mx
{
    static function run(...$commands)
    {
        try {
            $commands = array_map(fn ($v) => trim($v), $commands);
            $commands = array_filter($commands, fn ($v) => boolval($v));
            if (empty($commands)) $commands = ['logo'];

            $command = array_shift($commands);
            $params = $commands;

            $class = explode('.', $command);
            $class = array_map(fn ($v) => ucfirst($v), $class);
            $class = implode('', $class);
            $class = "\\Mx\\Mx$class";

            if (!class_exists($class) || !is_class($class, Mx::class))
                throw new Exception("Command [$command] not found");

            $instance = new $class;

            $reflection = new ReflectionMethod($instance, '__invoke');

            $countParams = count($params);

            foreach ($reflection->getparameters() as $required) {
                if ($countParams) {
                    $countParams--;
                } elseif (!$required->isDefaultValueAvailable()) {
                    $name = $required->getName();
                    throw new Exception("Parameter [$name] is required in [$command]");
                }
            }

            return $instance(...$params);
        } catch (Exception | Error $e) {
            self::echo('ERROR');
            self::echo(' | [#]', $e->getMessage());
            self::echo(' | [#] ([#])', [$e->getFile(), $e->getLine()]);
            return false;
        }
    }

    final static protected function echo(string $line = '', string|array $prepare = []): void
    {
        echo prepare("$line\n", $prepare);
    }

    protected function __construct()
    {
    }
}
