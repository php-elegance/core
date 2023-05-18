<?php

namespace Command;

use Elegance\Cif;
use Elegance\File;
use Elegance\Instance\InstanceCif;
use Elegance\MxCmd;
use Error;

abstract class MxCif
{
    static function create($name = null)
    {
        if (!$name)
            throw new Error('Informe um nome para o certificado');

        $fileName = "library/certificate/$name";

        File::ensure_extension($fileName, 'crt');
        $fileName = path($fileName);

        if (File::check($fileName))
            throw new Error("Certificado [$name] já existe");

        $allowChar = InstanceCif::BASE;

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

        File::create($fileName, $content, true);

        MxCmd::echo('Certificado [[#].crt] criado com sucesso.', $name);
        MxCmd::echo('Adicione [CIF_FILE=[#]] em suas variaveis de ambiente para defini-lo como padrão', $name);
        MxCmd::echo('Para chama-lo diretamente, use o codigo [new InstanceCif("[#]")]', $name);
    }

    static function on()
    {
        MxCmd::echo(Cif::on(implode(' ', func_get_args())));
    }

    static function off()
    {
        MxCmd::echo(Cif::off(implode(' ', func_get_args())));
    }
}
