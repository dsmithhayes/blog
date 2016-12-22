<?php

namespace Blog\Lib\Email;

use Blog\Lib\Email\Headers;

class Handler
{
    private $headers;

    public function __construct(Headers $headers)
    {
        $this->headers = $headers;
    }
}
