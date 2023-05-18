<?php

namespace Elegance;

use Error;
use Exception;
use ReflectionClass;
use ReflectionMethod;

abstract class MxCmd
{
    /** Executa comandos no terminal */
    static final function run(...$commands)
    {
        try {
            $commands = array_filter($commands);

            if (empty($commands)) $commands = ['logo'];

            foreach ($commands as $command) {

                $command = trim($command);

                if ($command) {
                    $params = explode(' ', $command);

                    $class = array_shift($params);

                    $method = explode(':', $class);
                    $class = array_shift($method);
                    $method = array_shift($method);
                    $method = empty($method) ? '__default' : $method;

                    $cmd = $class;

                    $class = explode('.', $class);
                    $class = array_map(fn ($value) => ucfirst($value), $class);
                    $class[] = "Mx" . array_pop($class);
                    $class = implode('\\', $class);
                    $class = "\\Command\\$class";

                    if (!class_exists($class))
                        throw new Error("Comando [$command] não encontrado");

                    if ($params != ['-h'] && method_exists($class, $method))
                        return $class::{$method}(...$params) ?? true;

                    self::echo("comandos [$cmd]");
                    self::echo("|");

                    foreach ((new ReflectionClass($class))->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                        $call = $method->name == '__default' ? '' : ":" . $method->name;
                        self::echo("| $cmd$call");
                    }

                    self::echo("|");
                    return false;
                }
            }
            return true;
        } catch (Exception | Error $e) {
            self::echo('ERROR');
            self::echo(' | [#]', $e->getMessage());
            self::echo(' | [#] ([#])', [$e->getFile(), $e->getLine()]);
            return false;
        }
    }

    /** Imprime uma linha no terminal */
    static final function echo(string $line = '', string|array $prepare = []): void
    {
        echo prepare("$line\n", $prepare);
    }
}
