<?php

namespace Elegance\Core;

abstract class Code
{
    protected static string $preKey = '';
    protected static string $posKey = '';
    protected static ?array $key = null;

    /** Retorna o codigo de uma string */
    static function on(mixed $var): string
    {
        self::__load();

        if (!self::check($var)) {
            if (!is_md5($var))
                $var = md5(is_stringable($var) ? "$var" : serialize($var));
            $in = str_split('1234567890abcdef');
            $out = self::$key;
            $var = str_replace($in, $out, $var);
            $var = self::$preKey . $var . self::$posKey;
        }

        return $var;
    }

    /** Retonra o MD5 usado para gerar uma string codificada */
    static function off(mixed $var): string
    {
        self::__load();

        if (!self::check($var))
            return self::off(self::on($var));

        $in = str_split('1234567890abcdef');
        $out = self::$key;
        $var = str_replace($out, $in, substr($var, 1, -1));

        return $var;
    }

    /** Verifica se uma variavel é uma string codificada */
    static function check(mixed $var): bool
    {
        self::__load();

        if (func_num_args() > 1) {
            $check = true;

            foreach (func_get_args() as $v)
                $check = $check && self::check($v);

            return $check && self::compare(...func_get_args());
        }

        return boolval(
            is_string($var) &&
                strlen($var) == 34 &&
                substr($var, 0, 1) == self::$preKey &&
                substr($var, -1) == self::$posKey &&
                empty(str_replace(self::$key, '', substr($var, 1, -1)))
        );
    }

    /** Verifica se todas as strings tem a mesma string codificada */
    static function compare(mixed $initial, mixed ...$compare): bool
    {
        $result = true;

        while ($result && count($compare))
            $result = boolval(self::off($initial) == self::off(array_shift($compare)));

        return $result;
    }

    protected static function __load()
    {
        if (is_null(self::$key))
            self::loadKey(env('CODE') ?? 'mx');
    }

    private static function loadKey($stringKey)
    {
        $baseChar = 'mxsiqjngplvouytwrh';

        $stringKey = preg_replace("/[^$baseChar]/", '', $stringKey);

        $stringKey = str_split($stringKey);

        $key = '';

        while (strlen($key) < 18 && count($stringKey)) {
            $char = array_shift($stringKey);
            if ($key == '' || strpos($key, $char) === false) {
                $key .= $char;
                $baseChar = str_replace($char, '', $baseChar);
            }
        }

        $key = substr("$key$baseChar", 0, 18);
        self::$preKey = substr($key, 0, 1);
        self::$posKey = substr($key, 1, 1);
        self::$key = str_split(substr($key, 2));
    }
}
