<?php

use Elegance\Env;

Env::loadFile('./.env');

Env::loadFile('./.config');

Env::default('DEV', false);
