<?php

namespace Elegance;

use Elegance\Instance\InstanceCode;

abstract class Code
{
    /** InstanceCode com chave padrão */
    protected static ?InstanceCode $instance;

    /** Retorna o codigo de uma string */
    static function on(mixed $var): string
    {
        return self::instance()->on(...func_get_args());
    }

    /** Retonra o MD5 usado para gerar uma string codificada */
    static function off(mixed $var): string
    {
        return self::instance()->off(...func_get_args());
    }

    /** Verifica se uma variavel é uma string codificada */
    static function check(mixed $var): bool
    {
        return self::instance()->check(...func_get_args());
    }

    /** Verifica se todas as strings tem a mesma string codificada */
    static function compare(mixed $initial, mixed ...$compare): bool
    {
        return self::instance()->compare(...func_get_args());
    }

    /** Retorna a InstanceCode com chave padrão */
    protected static function &instance(): InstanceCode
    {
        self::$instance = self::$instance ?? new InstanceCode;
        return self::$instance;
    }
}
