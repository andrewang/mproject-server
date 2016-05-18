<?php
/**
 * Copyright (c) 2016. Benjamin Rannow <rannow@emerise.de>
 * License: MIT
 * Author: Benjamin Rannow <rannow@emerise.de>
 * Project: M-Project
 */

namespace Scraper\Batoto;


use Scraper\lib\SimpleHTMLNode;
use Scraper\Scraper;
use Scraper\ScraperInterface;
use Scraper\lib\SimpleHTML;

class Batoto extends Scraper implements ScraperInterface
{
    const COMIC_URL = 'http://bato.to/comic/_/comics/';

    public function __construct($slug)
    {
        parent::__construct($slug);
        $this->url = self::COMIC_URL;
    }

    public function parse()
    {
        $opts = array(
            'http'=>array(
                'header'=> "Referer: http://bato.to/reader\r\n"
            )
        );

        $context = stream_context_create($opts);

        $dom = SimpleHTML::file_get_html('http://bato.to/areader?id=daa87bc2dc7cc7d7&p=1', false, $context);//$this->url.'/'.$this->slug);
        $dom->set_callback(array($this, 'parseElement'));
        $nodes = $dom->find('div.moderation_bar > ul > li > select');
        $img = $dom->getElementById('comic_page');
        $imgDownload = $img->getAttribute('src');
        /** @var SimpleHTMLNode $chapterSelect */
        $chapterSelect = $nodes[0];
        /** @var SimpleHTMLNode $pageSelect */
        $pageSelect = $nodes[2];
        /** @var SimpleHTMLNode $node */
        $pages = array();
        foreach ($pageSelect->children as $node) {
            $pages[$node->innertext()] = $node->getAttribute('value');
        }
        var_dump($pages);
         echo $dom;
    }

    public function parseElement(SimpleHTMLNode $element)
    {
    }
}
