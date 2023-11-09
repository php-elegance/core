<?php

namespace Mx;

use Elegance\Core\Dir;

class MxComposer extends Mx
{
    function __invoke()
    {
        $composer = jsonFile('composer');

        $composer['autoload'] = $composer['autoload'] ?? [];
        $composer['autoload']['psr-4'] = $composer['autoload']['psr-4'] ?? [];
        $composer['autoload']['files'] = $composer['autoload']['files'] ?? [];

        $composer['autoload']['psr-4'][''] = path('source/');

        $autoImport = path('helper');

        $files = [];

        foreach ($composer['autoload']['files'] as $file)
            if (substr($file, 0, strlen($autoImport)) != $autoImport)
                $files[] = $file;

        $files = [...$files, ...self::seek_for_file($autoImport)];

        $composer['autoload']['files'] = $files;

        jsonFile('composer', $composer, false);

        self::echo('Arquivo [composer.json] atualizado');

        env('DEV') ? self::update() : self::install();
    }

    protected static function update()
    {
        self::echo('------------------------------------------------------------');
        self::echo('composer update');
        self::echo('------------------------------------------------------------');
        echo shell_exec("composer update");
        self::echo('------------------------------------------------------------');
    }

    protected static function install()
    {
        self::echo('------------------------------------------------------------');
        self::echo('composer install --no-dev --optimize-autoloader');
        self::echo('------------------------------------------------------------');
        echo shell_exec("composer install --no-dev --optimize-autoloader");
        self::echo('------------------------------------------------------------');
    }

    protected static function seek_for_file($ref)
    {
        $return = [];

        foreach (Dir::seek_for_dir($ref) as $dir)
            foreach (self::seek_for_file("$ref/$dir") as $file)
                $return[] = path($file);

        foreach (Dir::seek_for_file($ref) as $file)
            $return[] = path("$ref/$file");

        return $return;
    }
}
