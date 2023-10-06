<?php

use Elegance\Env;

Env::loadFile('./.env');
Env::loadFile('./.conf');

Env::default('DEV', false);
