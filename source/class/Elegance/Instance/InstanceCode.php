<?php

namespace Elegance\Instance;

class InstanceCode
{
    protected string $strKey;
    protected string $preKey;
    protected string $posKey;
    protected array $key;

    function __construct(?string $key = null)
    {
        $baseChar = 'mxsiqjngplvouytwrh';
        $stringKey = $key ?? env('CODE') ?? 'elegance';
        $stringKey = strtolower($stringKey);

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
        $this->preKey = substr($key, 0, 1);
        $this->posKey = substr($key, 1, 1);
        $this->key = str_split(substr($key, 2));
    }

    /** Retorna o codigo de uma string */
    function on(mixed $var): string
    {
        if (!$this->check($var)) {
            if (!is_md5($var))
                $var = md5(is_stringable($var) ? "$var" : serialize($var));
            $in = str_split('1234567890abcdef');
            $out = $this->key;
            $var = str_replace($in, $out, $var);
            $var = $this->preKey . $var . $this->posKey;
        }

        return $var;
    }

    /** Retonra o MD5 usado para gerar uma string codificada */
    function off(mixed $var): string
    {
        if (!$this->check($var))
            return $this->off($this->on($var));

        $in = str_split('1234567890abcdef');
        $out = $this->key;
        $var = str_replace($out, $in, substr($var, 1, -1));
        return $var;
    }

    /** Verifica se uma variavel é uma string codificada */
    function check(mixed $var): bool
    {
        if (func_num_args() > 1) {
            $check = true;

            foreach (func_get_args() as $v)
                $check = $check && $this->check($v);

            return $check && $this->compare(...func_get_args());
        }

        return boolval(
            is_string($var) &&
                strlen($var) == 34 &&
                substr($var, 0, 1) == $this->preKey &&
                substr($var, -1) == $this->posKey &&
                empty(str_replace($this->key, '', substr($var, 1, -1)))
        );
    }

    /** Verifica se todas as strings tem a mesma string codificada */
    function compare(mixed $initial, mixed ...$compare): bool
    {
        $result = true;

        while ($result && count($compare))
            $result = boolval($this->off($initial) == $this->off(array_shift($compare)));

        return $result;
    }
}
