<?php

namespace Command\Create;

use Elegance\File;
use Elegance\Import;
use Elegance\MxCmd;
use Error;

abstract class MxCommand
{
    static function __default($commandName = null)
    {
        if (!$commandName)
            throw new Error("Informe o nome do comando");

        $tmp = $commandName;
        $tmp = explode('.', $tmp);
        $tmp = array_map(fn ($value) => ucfirst($value), $tmp);

        $class = "Mx" . array_pop($tmp);

        $namespace = implode('\\', $tmp);
        $namespace = trim("Command\\$namespace", '\\');

        $path = str_replace('\\', '/', $namespace);

        $filePath = path("source/class/$path/$class.php");

        if (File::check($filePath))
            throw new Error("Arquivo [$filePath] já existe");

        $prepare = [
            '[#]',
            'name' => $commandName,
            'class' => $class,
            'namespace' => $namespace,
            'PHP' => '<?php'
        ];

        $base = path(dirname(__DIR__, 4) . '/library/template/mx/command.txt');

        $content = Import::content($base, $prepare);

        File::create($filePath, $content);

        MxCmd::echo('Comando [[#]] criado com sucesso.', $commandName);
    }
}
