<?php
/**
 * Copyright (c) 2016. Benjamin Rannow <rannow@emerise.de>
 * License: MIT
 * Author: Benjamin Rannow <rannow@emerise.de>
 * Project: M-Project
 */

declare(strict_types=1);

namespace Core\Template;

class Templare
{
    /**
     * @var TemplateFile
     */
    protected $template;

    /**
     * Templare constructor.
     */
    public function __construct(string $templateName)
    {
        $this->template = $this->loadTemplate($templateName);
    }

    /**
     * @param string $templateName
     * @return TemplateFile
     */
    protected function loadTemplate(string $templateName): TemplateFile
    {
        return new TemplateFile($templateName);
    }
}