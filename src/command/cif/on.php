<?php

namespace Elegance\Core;

// php mx cif.on

return function ($value) {
    Terminal::echo(Cif::on(implode(' ', func_get_args())));
};
