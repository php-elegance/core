<?php

namespace Elegance;

// php mx create.command

return function ($commandName) {

    $name = $commandName;

    $command = strtolower($commandName);
    $command = str_replace('.', '/', $command);
    $command = path("$command.php");

    $template = path("#elegance-mx/source/template/mx/command.txt");
    $template = Import::content($template);
    $template = prepare($template, ['name' => $name]);

    File::create("source/command/$command", $template);

    Terminal::echo('Comando [[#]] criado com sucesso.', $name);
};