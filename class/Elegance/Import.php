<?php

namespace Elegance;

use Error;
use Exception;

abstract class Import
{
    /** Importa um arquivo PHP */
    static function only(string $filePath, bool $once = true): bool
    {
        $filePath = path($filePath);
        $filePath = File::setEx($filePath, 'php');
        try {
            _logSection('import-only', $filePath);

            $once ? require_once $filePath : require $filePath;

            _logSection();
            return true;
        } catch (Exception | Error) {
            return false;
        }
    }

    /** Retorna o conteúdo de um aquivo */
    static function content(string $filePath, string|array $prepare = []): string
    {
        _logSection('import-content', $filePath);

        $filePath = path($filePath);

        $content = File::check($filePath) ? file_get_contents($filePath) : '';

        $return = Prepare::prepare($content, $prepare);

        _logSection();

        return $return;
    }

    /** Retorna o resultado (return) em um arquivo php  */
    static function return(string $filePath, array $params = []): mixed
    {
        $filePath = path($filePath);
        $filePath = File::setEx($filePath, 'php');

        if (File::check($filePath)) {

            _logSection('import-return', $filePath);

            $return = function ($__FILEPATH__, &$__PARAMS__) {
                foreach (array_keys($__PARAMS__) as $__KEY__)
                    if (!is_numeric($__KEY__))
                        $$__KEY__ = &$__PARAMS__[$__KEY__];
                ob_start();
                $__RETURN__ = require $__FILEPATH__;
                ob_end_clean();
                return $__RETURN__;
            };

            $return = $return($filePath, $params);

            _logSection();
        }

        return $return ?? null;
    }

    /** Retorna o valor de uma variavel dentro de em um arquivo php  */
    static function var(string $filePath, string $varName, array $params = []): mixed
    {
        $filePath = path($filePath);
        $filePath = File::setEx($filePath, 'php');

        if (File::check($filePath)) {

            _logSection('import-var', $filePath);

            $return = function ($__FILEPATH__, $__VARNAME__, &$__PARAMS__) {
                foreach (array_keys($__PARAMS__) as $__KEY__)
                    if (!is_numeric($__KEY__))
                        $$__KEY__ = &$__PARAMS__[$__KEY__];
                ob_start();
                require $__FILEPATH__;
                $__RETURN__ = $$__VARNAME__ ?? null;
                ob_end_clean();
                return $__RETURN__;
            };

            $return = $return($filePath, $varName, $params);

            _logSection();
        }

        return $return ?? null;
    }

    /** Retorna a saída de texto gerada por um arquivo */
    static function output(string $filePath, array $params = []): string
    {
        $filePath = path($filePath);

        if (File::check($filePath)) {

            _logSection('import-output', $filePath);

            $return = function ($__FILEPATH__, &$__PARAMS__) {
                foreach (array_keys($__PARAMS__) as $__KEY__)
                    if (!is_numeric($__KEY__))
                        $$__KEY__ = &$__PARAMS__[$__KEY__];
                ob_start();
                require $__FILEPATH__;
                $__RETURN__ = ob_get_clean();
                return $__RETURN__;
            };

            $return = $return($filePath, $params);

            _logSection();
        }

        return $return ?? '';
    }
}
