<?php

namespace Mx;

use Elegance\Core\File;
use Elegance\Core\Import;
use Exception;

class MxCreateCommand extends Mx
{
    function __invoke($commandName)
    {
        $command = $commandName;

        $class = explode('.', $command);
        $class = array_map(fn ($v) => ucfirst($v), $class);
        $class = implode('', $class);
        $class = "Mx$class";
        $file = "source/Mx/$class.php";

        if (File::check($file))
            throw new Exception("Command [$command] already exists");

        $template = path("#elegance-core/view/template/mx/command.txt");

        $template = Import::content($template);
        $template = prepare($template, [
            'class' => $class,
            'command' => $command
        ]);

        File::create($file, $template);

        self::echo('Comando [[#]] criado com sucesso.', $command);
    }
}
