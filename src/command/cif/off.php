<?php

// php mx cif.off

use Elegance\Core\Cif;

return function ($value) {
    var_dump(Cif::off($value));
};
