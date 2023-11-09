<?php

namespace Mx;

use Elegance\Core\Cif;

class MxCifOff extends Mx
{
    function __invoke($value)
    {
        var_dump(Cif::off($value));
    }
}
