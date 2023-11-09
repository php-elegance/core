<?php

// php mx cif.on

use Elegance\Core\Cif;
use Elegance\Core\Terminal;

return function ($value) {
    Terminal::echo(Cif::on(implode(' ', func_get_args())));
};
