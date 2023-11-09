<?php

namespace Mx;

use Elegance\Core\Code;

class MxCodeOn extends Mx
{
    function __invoke($value)
    {
        self::echo(Code::on(implode(' ', func_get_args())));
    }
}
