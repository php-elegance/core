<?php

use Elegance\Core\Env;

Env::loadFile('./.env');
Env::loadFile('./.conf');

Env::default('DEV', false);
