<?php
/**
 * Copyright (c) 2016. Benjamin Rannow <rannow@emerise.de>
 * License: MIT
 * Author: Benjamin Rannow <rannow@emerise.de>
 * Project: M-Project
 */

declare(strict_types=1);

namespace Api\Import;

use Core\Controller\Controller;
use Scraper\Batoto\Batoto;

class Collector extends Controller
{
    public function scrapeData(string $scraper, string $name)
    {
        $batoto = new Batoto('helck-r17710');
        $batoto->parse();
        return $this->response($scraper.' - '.$name);
    }
}