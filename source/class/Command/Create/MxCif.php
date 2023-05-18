<?php

namespace Command\Create;

use Elegance\MxCmd;

abstract class MxCif
{
    static function __default($name = null)
    {
        MxCmd::run("cif:create $name");
    }
}
