<?php

namespace Elegance;

use Error;

abstract class Cif
{
    protected static array $ensure;
    protected static ?int $currentIdKey = null;
    protected static ?array $cif = null;

    final const BASE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    /** Retorna a cifra de uma variavel */
    static function on(mixed $var, ?string $charKey = null): string
    {
        self::loadCtfFile();

        if (
            is_string($var)
            && str_starts_with($var, '-')
            && str_ends_with($var, '-')
            && self::checkEncapsChar(substr($var, 1, -1))
        ) return $var;

        $idKey = self::getUseIdKey($charKey);

        $var = serialize($var);

        $var = base64_encode($var);

        $var = str_replace('=', '', $var);

        $var = strrev($var);

        $var = self::replace($var, self::BASE, self::$cif[$idKey]);

        $var = self::getEncapsChar($idKey) . $var . self::getEncapsChar($idKey, true);

        $var = str_replace('/', '-', $var);
        $var = "-$var-";

        return $var;
    }

    /** Retorna a variavel de uma cifra */
    static function off(mixed $var): mixed
    {
        if (!self::check($var)) return $var;

        if (strpos($var, ' ') !== false) $var = urlencode($var);

        $key = self::getUseIdKey(substr($var, 1, 1));

        $var = substr($var, 2, -2);

        $var = str_replace('-', '/', $var);

        $var = self::replace($var, self::$cif[$key], self::BASE);

        $var = base64_decode(strrev($var));

        if (is_serialized($var))
            $var = unserialize($var);

        return $var;
    }

    /** Verifica se uma variavel atende os requisitos para ser uma cifra */
    static function check(mixed $var): bool
    {
        if (func_num_args() > 1) {
            $check = true;
            foreach (func_get_args() as $v)
                $check = $check && self::check($v);
            return $check && self::compare(...func_get_args());
        }

        return $var == self::on($var);

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

    /** Carrega o arquivo de certificado do projeto */
    protected static function loadCtfFile()
    {
        if (is_null(self::$cif)) {
            $certificate = env('CIF');

            if ($certificate) {
                $certificate = path('library/certificate', $certificate);
                $certificate = File::setEx($certificate, 'crt');
                $certificate = path($certificate);
            } else {
                $certificate = path('#elegance-core/library/certificate/base.crt');
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

    /** Realiza o replace interno de uma string */
    protected static function replace(string $string, string $in, string $out): string
    {
        for ($i = 0; $i < strlen($string); $i++)
            if (strpos($in, $string[$i]) !== false)
                $string[$i] = $out[strpos($in, $string[$i])];

        return $string;
    }

    /** Retorna o id que deve ser utilizado */
    protected static function getUseIdKey(?string $charKey): int
    {
        self::loadCtfFile();

        self::$currentIdKey = self::$currentIdKey ?? random_int(0, 61);

        if (!is_null($charKey))
            $idKey = array_flip(self::$ensure)[substr($charKey, 0, 1)];

        return $idKey ?? self::$currentIdKey;
    }

    /** Retorna o caracter de encapsulamento */
    protected static function getEncapsChar(int $idKey, bool $reverse = false): string
    {
        if ($reverse) $idKey = 61 - $idKey;
        $charKey = self::$ensure[$idKey] ?? 0;
        return $charKey;
    }

    /** Verifica os caracteres de encapsulamento de uma string */
    protected static function checkEncapsChar(string $string)
    {
        $idCharKeyStart = self::getUseIdKey(substr($string, 0, 1));
        return self::getEncapsChar($idCharKeyStart, true) == substr($string, -1, 1);
    }
}
