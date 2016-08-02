<?php
/**
 * Copyright (c) 2016. Benjamin Rannow <rannow@emerise.de>
 * License: MIT
 * Author: Benjamin Rannow <rannow@emerise.de>
 * Project: M-Project
 */

declare(strict_types=1);

namespace Test;

use Core\Controller\Controller;

class Test extends Controller
{
    public function indexAction()
    {
        return $this->response('test');
    }
}