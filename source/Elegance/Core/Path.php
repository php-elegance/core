<?php

namespace Elegance\Core;

abstract class Path
{
    protected static array $alias = [];

    /** Define um atalho para um diretório */
    static function alias(string $name, string $path)
    {
        self::$alias["#$name"] = $path;
    }

    /** Retorna os atalhos de diretório adicionados */
    static function getAlias(): array
    {
        return self::$alias;
    }

    /** Formata um caminho de diretório */
    static function path(...$path): string
    {
        $path = implode('/', $path);

        if (str_starts_with($path, './'))
            $path = substr($path, 2);

        $path = self::applyAlias($path);

        $path = str_replace('\\', '/', $path);
        $path = str_trim($path, '/', '/ ');
        $path = str_replace_all('//', '/', $path);

        $path = self::removeCurrentPath($path);

        return $path;
    }

    /** Retorno o caminho para o arquivo que chamou esta helper */
    static function ipath(int $limit = 1): string
    {
        $path = debug_backtrace(2, $limit);
        $path = array_pop($path);
        $path = $path['file'];
        $path = Dir::getOnly($path);

        return $path;
    }

    /** Remove o caminho padrão do PHP */
    protected static function applyAlias($path)
    {
        if (str_starts_with($path, '#')) {
            foreach (self::$alias as $aliasName => $aliasPath)
                if (str_starts_with($path, $aliasName))
                    return str_replace_first($aliasName, $aliasPath, $path);
        }
        return $path;
    }

    /** Remove o caminho padrão do PHP */
    protected static function removeCurrentPath($path)
    {
        $currentPath = getcwd();
        $currentPath = str_replace('\\', '/', $currentPath);
        if (str_starts_with($path, $currentPath)) {
            $path = substr($path, strlen($currentPath));
            $path = trim($path, '/');
        }
        return $path;
    }
}
