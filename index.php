<?php
/**
 * Copyright (c) 2016. Benjamin Rannow <rannow@emerise.de>
 * License: MIT
 * Author: Benjamin Rannow <rannow@emerise.de>
 * Project: M-Project
 */

declare(strict_types=1);

include 'core/autoLoader.php';

use Core\HTTP\Request;
use Core\Kernel;

$request = Request::createFromGlobals();
$kernel = new Kernel();
$response = $kernel->execute($request);
$response->send();
$kernel->terminate();