<?php
/**
 * Copyright (c) 2016. Benjamin Rannow <rannow@emerise.de>
 * License: MIT
 * Author: Benjamin Rannow <rannow@emerise.de>
 * Project: M-Project
 */

return array(
    'router' => array(
        '/api/v1/data/manga/{id}/' => array(
            'controller' => 'Api\v1\Data',
            'method' => 'getManga',
            'types' => array(
                'id' => 'int'
            )
        ),
        '/api/import/manga/{scraper}/{name}/' => array(
            'controller' => 'Api\Import\Collector',
            'method' => 'scrapeData',
            'types' => array(
                'scraper' => 'string',
                'name' => 'string'
            )
        )
    )
);