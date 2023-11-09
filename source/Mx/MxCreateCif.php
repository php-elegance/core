<?php

namespace Mx;

use Elegance\Core\Cif;
use Elegance\Core\File;
use Exception;

class MxCreateCif extends Mx
{
    function __invoke($cifName)
    {
        $file = path("library/certificate/$cifName");
        $file = File::setEx($file, 'crt');

        if (File::check($file))
            throw new Exception("Cif file [$cifName] already exists");

        $allowChar = Cif::BASE;

        $content = [];
        while (count($content) < 63) {
            $charKey = str_shuffle($allowChar);

            while ($charKey == $allowChar || in_array($charKey, $content))
                $charKey = str_shuffle($allowChar);

            $charKey = implode(' ', str_split($charKey, 2));
            $content[] = $charKey;
        }

        $content = implode(' ', $content);

        $content = str_split($content, 21);

        $content = array_map(fn ($value) => trim($value), $content);

        $content = implode("\n", $content);

        File::create($file, $content, true);

        self::echo('Certificado [[#].crt] criado com sucesso.', $cifName);
        self::echo('Para utilizar o novo arquivo em seu projeto, adicione a linha abaixo em suas variaveis de ambiente');
        self::echo('');
        self::echo('CIF = [#]', $cifName);
    }
}
