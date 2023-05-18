<?php

namespace Command;

use Elegance\Dir;
use Elegance\MxCmd;

abstract class MxComposer
{
    static function __default()
    {
        $composer = jsonFile('composer');

        $composer['autoload'] = $composer['autoload'] ?? [];
        $composer['autoload']['psr-4'] = $composer['autoload']['psr-4'] ?? [];
        $composer['autoload']['files'] = $composer['autoload']['files'] ?? [];

        $composer['autoload']['psr-4'][''] = path('source/class/');

        $autoImport = path('source/helper');

        $files = [];

        foreach ($composer['autoload']['files'] as $file)
            if (substr($file, 0, strlen($autoImport)) != $autoImport)
                $files[] = $file;

        $files = [...$files, ...self::seek_for_file($autoImport)];

        $composer['autoload']['files'] = $files;

        jsonFile('composer', $composer, false);

        MxCmd::echo('Arquivo [composer.json] atualizado');

        self::update();
    }

    protected static function update()
    {
        MxCmd::echo('------------------------------------------------------------');
        echo shell_exec("composer update");
        MxCmd::echo('------------------------------------------------------------');
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
