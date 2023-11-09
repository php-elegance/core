<?php

namespace Mx;

use Elegance\Core\Code;

class MxCodeOff extends Mx
{
    function __invoke($value)
    {
        self::echo(Code::off($value));
    }
}
