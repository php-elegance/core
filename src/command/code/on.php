<?php

namespace Elegance\Core;

// php mx code.on

return function ($value) {
    Terminal::echo(Code::on(implode(' ', func_get_args())));
};
