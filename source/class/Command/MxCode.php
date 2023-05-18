<?php

namespace Command;

use Elegance\Code;
use Elegance\MxCmd;

abstract class MxCode
{
    static function on()
    {
        MxCmd::echo(Code::on(implode(' ', func_get_args())));
    }

    static function off()
    {
        MxCmd::echo(Code::off(implode(' ', func_get_args())));
    }
}
