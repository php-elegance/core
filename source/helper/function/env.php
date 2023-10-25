<?php

use Elegance\Env;

if (!function_exists('env')) {

    /** Recupera o valor de uma variavel de ambiente */
    function env(string $name, mixed $defaultValue = null): mixed
    {
        return Env::get($name) ?? $defaultValue;
    }
}
