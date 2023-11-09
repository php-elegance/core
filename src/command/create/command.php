<?php

// php mx create.command

use Elegance\Core\File;
use Elegance\Core\Import;
use Elegance\Core\Terminal;

return function ($commandName) {

    $name = $commandName;

    $command = strtolower($commandName);
    $command = str_replace('.', '/', $command);
    $command = path("$command.php");

    $template = path("#elegance-core/view/template/mx/command.txt");
    $template = Import::content($template);
    $template = prepare($template, ['name' => $name]);

    File::create("src/command/$command", $template);

    Terminal::echo('Comando [[#]] criado com sucesso.', $name);
};
