<?php
/**
 * Copyright (c) 2016. Benjamin Rannow <rannow@emerise.de>
 * License: MIT
 * Author: Benjamin Rannow <rannow@emerise.de>
 * Project: M-Project
 */

declare(strict_types=1);

namespace Core\HTTP;

/**
 * Class Response
 * @package Core\HTTP
 */
class Response
{
    /**
     * @var int
     */
    protected $status = 200;

    /**
     * @var string
     */
    protected $content = '';

    /**
     * @var string
     */
    protected $type = '';

    /**
     * Response constructor.
     * @param string $content
     * @param int $code
     */
    public function __construct(string $content, int $code = 200)
    {
        $this->content = $content;
        $this->status = $code;
    }

    /**
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Response
     */
    public function setType(string $type) : Response
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param int $code
     * @return Response
     */
    public function setStatusCode(int $code) : Response
    {
        $this->status = $code;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode() : int
    {
        return $this->status;
    }

    /**
     * @param string $content
     * @return Response
     */
    public function setContent(string $content) : Response
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent() : string
    {
        return $this->content;
    }

    /**
     * @return Response
     */
    protected function sendHeaders() : Response
    {
        if (headers_sent()) {

            return $this;
        }

        http_response_code($this->status);
        header('Cache-Control: public');
        header('Content-length: ' . strlen($this->content));
        header('Pragma: no-cache');
        header('Expires: 0');
        header('Accept-Ranges: bytes');
        $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('UTC'));
        header('Date: '. $date->format('D, d M Y H:i:s').' GMT');

        if (!empty($this->type)) {
            header('Content-Type: ' . $this->type);
        }

        return $this;
    }

    /**
     * @return Response
     */
    public function sendContent() : Response
    {
        echo $this->content;

        return $this;
    }

    /**
     * @return Response
     */
    public function send() : Response
    {
        $this->sendHeaders();
        $this->sendContent();

        return $this;
    }
}