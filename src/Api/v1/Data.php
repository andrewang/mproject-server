<?php
/**
 * Copyright (c) 2016. Benjamin Rannow <rannow@emerise.de>
 * License: MIT
 * Author: Benjamin Rannow <rannow@emerise.de>
 * Project: M-Project
 */

declare(strict_types=1);

namespace Api\v1;

use Core\Controller\Controller;

class Data extends Controller
{
    public function getManga(int $id)
    {
        return $this->jsonResponse(array('id' => $id));
    }
}