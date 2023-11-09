<?php

// php mx code.off

use Elegance\Core\Code;
use Elegance\Core\Terminal;

return function ($value) {
    Terminal::echo(Code::off($value));
};
