<?php

namespace Elegance;

use Closure;
use Error;
use Exception;
use ReflectionFunction;
use ReflectionMethod;

abstract class Terminal
{
    static function run(...$commands)
    {
        try {
            $commands = implode(' ', $commands);
            $commands = str_replace_all('  ', ' ', $commands);
            $commands = trim($commands);
            $commands = empty($commands) ? ['logo'] : explode(' ', $commands);

            $params = $commands;

            $command = array_shift($params);
            $command = str_replace('.', '/', $command);

            $alias = Path::getAlias();
            $alias = array_keys($alias);

            $path = path(strtolower("source/command/$command.php"));

            while (!File::check($path) && count($alias))
                $path = path(array_pop($alias), strtolower("source/command/$command.php"));

            if (!File::check($path))
                throw new Error("Comando [$command] não encontrado");

            $action = Import::return($path);

            if (!is_closure($action))
                throw new Error("Impossivel executar comando [$command]");

            $reflection = $action instanceof Closure ? new ReflectionFunction($action) : new ReflectionMethod($action, '__invoke');
            $countParams = count($params);

            foreach ($reflection->getparameters() as $required) {
                if ($countParams) {
                    $countParams--;
                } elseif (!$required->isDefaultValueAvailable()) {
                    $name = $required->getName();
                    throw new Exception("Parameter [$name] is required");
                }
            }

            return $action(...$params) ?? true;
        } catch (Exception | Error $e) {
            self::echo('ERROR');
            self::echo(' | [#]', $e->getMessage());
            self::echo(' | [#] ([#])', [$e->getFile(), $e->getLine()]);
            return false;
        }
    }

    static final function echo(string $line = '', string|array $prepare = []): void
    {
        echo prepare("$line\n", $prepare);
    }
}
