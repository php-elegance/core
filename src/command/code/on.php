<?php

// php mx code.on

use Elegance\Core\Code;
use Elegance\Core\Terminal;

return function ($value) {
    Terminal::echo(Code::on(implode(' ', func_get_args())));
};
