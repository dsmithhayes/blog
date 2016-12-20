<?php

namespace Blog\Lib\Email;

class Headers
{
    /**
     * @var array
     *      Array of headers
     */
    private $headers;

    /**
     * @param string $key
     * @param string $value
     */
    public function addHeader(string $key, string $value)
    {
        $this->headers[$key] = $value;
    }

    public function __toString(): string
    {
        foreach ($this->headers as $key => $value) {
            $strings[] = "{$key}: {$value}";
        }

        return implode('\r\n', $strings)
    }
}
