<?php

namespace Elegance;

// php mx composer


return new class
{
    function __invoke()
    {
        $composer = jsonFile('composer');

        $composer['autoload'] = $composer['autoload'] ?? [];
        $composer['autoload']['psr-4'] = $composer['autoload']['psr-4'] ?? [];
        $composer['autoload']['files'] = $composer['autoload']['files'] ?? [];

        $composer['autoload']['psr-4'][''] = path('class/');

        $autoImport = path('src/helper');

        $files = [];

        foreach ($composer['autoload']['files'] as $file)
            if (substr($file, 0, strlen($autoImport)) != $autoImport)
                $files[] = $file;

        $files = [...$files, ...self::seek_for_file($autoImport)];

        $composer['autoload']['files'] = $files;

        jsonFile('composer', $composer, false);

        Terminal::echo('Arquivo [composer.json] atualizado');

        env('DEV') ? self::update() : self::install();
    }

    protected static function update()
    {
        Terminal::echo('------------------------------------------------------------');
        Terminal::echo('composer update');
        Terminal::echo('------------------------------------------------------------');
        echo shell_exec("composer update");
        Terminal::echo('------------------------------------------------------------');
    }

    protected static function install()
    {
        Terminal::echo('------------------------------------------------------------');
        Terminal::echo('composer install --no-dev --optimize-autoloader');
        Terminal::echo('------------------------------------------------------------');
        echo shell_exec("composer install --no-dev --optimize-autoloader");
        Terminal::echo('------------------------------------------------------------');
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
};
