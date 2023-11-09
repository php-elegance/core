<?php

namespace Mx;

use Elegance\Core\Cif;

class MxCifOn extends Mx
{
    function __invoke($value)
    {
        self::echo(Cif::on(implode(' ', func_get_args())));
    }
}
