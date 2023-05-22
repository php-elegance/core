<?php

use Elegance\Dir;

if (!function_exists('path')) {

    /** Formata um caminho de diretório */
    function path(): string
    {
        $path = array_filter(func_get_args(), fn ($i) => !is_blank($i));
        $path = str_replace('\\', '/', implode('/', $path));
        $path = str_trim($path, '/', '/ ');
        $path = str_replace_all('//', '/', $path);

        $currentPath = getcwd();
        $currentPath = str_replace('\\', '/', $currentPath);

        if (str_starts_with($path, $currentPath)) {
            $path = substr($path, strlen($currentPath));
            $path = trim($path, '/');
        }

        return $path;
    }
}

if (!function_exists('ipath')) {

    /** Retorno o caminho para o arquivo que chamou esta helper */
    function ipath(int $limit): string
    {
        $path = debug_backtrace(2, $limit);
        $path = array_pop($path);
        $path = $path['file'];
        $path = Dir::getOnly($path);

        return $path;
    }
}
