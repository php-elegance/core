<?php

use Elegance\Core\Path;

if (!function_exists('path')) {

    /** Formata um caminho de diretório */
    function path(...$path): string
    {
        return Path::path(...$path);
    }
}

if (!function_exists('ipath')) {

    /** Retorno o caminho para o arquivo que chamou esta helper */
    function ipath(int $limit = 1): string
    {
        return Path::ipath($limit + 1);
    }
}
