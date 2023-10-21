<?php

namespace Elegance;

use Error;

abstract class Cif
{
    protected static array $ensure;
    protected static string $currentKey;
    protected static ?array $cif = null;

    final const BASE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    protected static function load()
    {
        if (is_null(self::$cif)) {
            $certificate = env('CIF');

            if ($certificate) {
                $certificate = path('source/certificate', $certificate);
                $certificate = File::setEx($certificate, 'crt');
                $certificate = path($certificate);
            } else {
                $certificate = path('#elegance-core/source/certificate/base.crt');
            }

            if (!File::check($certificate))
                throw new Error("Impossivel localizar o arquivo de certificado [$certificate].");

            $content = Import::content($certificate);
            $content = str_replace([" ", "\t", "\n", "\r", "\0", "\x0B"], '', $content);
            $cif = str_split($content, 62);

            self::$ensure = str_split(array_pop($cif));
            self::$cif = $cif;
        }
    }

    /** Retorna a cifra de uma variavel */
    static function on(mixed $var, ?string $key = null): string
    {
        self::load();

        if (self::check($var))
            return $var;

        if ($key !== false) {

            $key = ($key !== null && $key !== true)
                ? self::get_key_char(substr("$key", 0, 1))
                : self::get_key();

            $stringCif = serialize($var);

            $stringCif = base64_encode($stringCif);

            $stringCif = str_replace('=', '', $stringCif);

            $stringCif = strrev($stringCif);

            $stringCif = self::replace($stringCif, self::BASE, self::$cif[$key]);

            $stringCif = self::get_char_key($key) . $stringCif . self::get_char_key($key, true);

            $stringCif = str_replace('/', '-', $stringCif);

            $stringCif = "-$stringCif-";
        }

        return $stringCif ?? $var;
    }

    /** Retorna a variavel de uma cifra */
    static function off(mixed $var): mixed
    {
        self::load();

        if (strpos($var, ' ') !== false)
            $var = urlencode($var);

        if (!self::check($var))
            return $var;

        $key = self::get_key_char(substr($var, 1, 1));

        $var = substr($var, 2, -2);

        $var = str_replace('-', '/', $var);

        $var = self::replace($var, self::$cif[$key], self::BASE);

        $var = base64_decode(strrev($var));

        $var = unserialize($var);

        return $var;
    }

    /** Verifica se uma variavel atende os requisitos para ser uma cifra */
    static function check(mixed $var): bool
    {
        self::load();

        if (func_num_args() > 1) {
            $check = true;

            foreach (func_get_args() as $v)
                $check = $check && self::check($v);

            return $check && self::compare(...func_get_args());
        }

        if (is_string($var))
            if (is_base64($var))
                if (substr($var, 0, 1) == '-')
                    if (substr($var, -1) == '-') {
                        $key = self::get_key_char(substr($var, 1, 1));
                        return substr($var, -2, 1) == self::get_char_key($key, true);
                    }

        return false;
    }

    /** Verifica se todas as variaveis tem a mesma cifra */
    static function compare(mixed $initial, mixed ...$compare): bool
    {
        $result = true;

        while ($result && count($compare))
            $result = boolval(self::off($initial) == self::off(array_shift($compare)));

        return $result;
    }

    /** Realiza o replace interno de uma string */
    protected static function replace(string $string, string $in, string $out): string
    {
        for ($i = 0; $i < strlen($string); $i++)
            if (strpos($in, $string[$i]) !== false)
                $string[$i] = $out[strpos($in, $string[$i])];

        return $string;
    }

    /** Retorna uma chave */
    protected static function get_key(bool $random = true): string
    {
        if ($random) {
            return random_int(0, 61);
        } else {
            self::$currentKey = self::$currentKey ?? random_int(0, 61);
            return self::$currentKey;
        }
    }

    /** Retorna a chave de um caracter */
    protected static function get_key_char(string $char): string
    {
        return array_flip(self::$ensure)[$char] ?? 0;
    }

    /** Retorna o caracter de uma chave */
    protected static function get_char_key(string $key, bool $inverse = false): string
    {
        $key = $inverse ? 61 - $key : $key;
        $key = self::$ensure[$key] ?? 0;
        return $key;
    }
}
