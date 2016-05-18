<?php
/**
 * Copyright (c) 2016. Benjamin Rannow <rannow@emerise.de>
 * License: MIT
 * Author: Benjamin Rannow <rannow@emerise.de>
 * Project: M-Project
 */

namespace Scraper;


use Scraper\lib\SimpleHTMLNode;

class Scraper implements ScraperInterface
{
    protected $url;
    protected $slug;

    public function __construct(string $slug)
    {
        $this->slug = $slug;
    }

    public function parse()
    {
    }

    public function parseElement(SimpleHTMLNode $element)
    {
    }
}