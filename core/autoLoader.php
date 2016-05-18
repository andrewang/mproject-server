<?php
/**
 * Copyright (c) 2016. Benjamin Rannow <rannow@emerise.de>
 * License: MIT
 * Author: Benjamin Rannow <rannow@emerise.de>
 * Project: M-Project
 */

declare(strict_types=1);

spl_autoload_register('mProject_autoLoader');

const _AUTOLOAD_CORE = 'core';
const _AUTOLOAD_SRC = 'src';

function mProject_autoLoader(string $class)
{
    if (stripos($class, _AUTOLOAD_CORE) === false) {
        $class = _AUTOLOAD_SRC.'/'.$class;
    } else {
        $class{0} = 'c';
    }

    $class = str_replace('\\', '/', $class);
    $class .= '.php';

    if (file_exists($class)) {
        /** @noinspection PhpIncludeInspection */
        include_once $class;
    }
}
