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
        return $this;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getHeader(string $key): string
    {
        return $this->headers[$key];
    }

    /**
     * @return string
     *      All of the headers as a single string
     */
    public function __toString(): string
    {
        foreach ($this->headers as $key => $value) {
            $strings[] = "{$key}: {$value}";
        }

        return (string) implode('\r\n', $strings);
    }
}
