<?php
/**
 * Copyright (c) 2016. Benjamin Rannow <rannow@emerise.de>
 * License: MIT
 * Author: Benjamin Rannow <rannow@emerise.de>
 * Project: M-Project
 */

class URLTest extends PHPUnit_Framework_TestCase
{
    public function testCreateFromGlobals()
    {
        $url = \Core\HTTP\URL::createFromGlobals();

        $this->assertEquals('http', $url->getScheme());
        $url->setScheme('https');
        $this->assertEquals('https', $url->getScheme());

        $this->assertEquals('fuyukai.moe', $url->getHost());
        $url->setHost('example.com');
        $this->assertEquals('example.com', $url->getHost());

        $this->assertEquals('/api/v1/data/manga/1/', $url->getPath());
        $url->setPath('/test/path/foo/bar/');
        $this->assertEquals('/test/path/foo/bar/', $url->getPath());


        $this->assertTrue(is_array($url->getQueries()) && !empty($url->getQueries()));
        $this->assertArrayNotHasKey('abc', $url->getQueries());
        $this->assertArrayHasKey('test', $url->getQueries());
        $url->setQueries([]);
        $this->assertEmpty($url->getQueries());
    }

    public function setUp()
    {
        $_SERVER['SERVER_NAME'] = 'fuyukai.moe';
        $_SERVER['REQUEST_URI'] = '/api/v1/data/manga/1/?test=123#abc';
    }

    public function tearDown()
    {
        unset($_SERVER['HTTPS']);
        unset($_SERVER['SERVER_NAME']);
        unset($_SERVER['REQUEST_URI']);
    }
}