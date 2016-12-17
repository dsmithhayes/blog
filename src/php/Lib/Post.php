<?php

namespace Blog\Lib;

class Post
{
    /**
     * @var string
     *      The title of the post
     */
    private $title;

    /**
     * @var string
     *      The body of the blog post
     */
    private $body;

    /**
     * @var bool
     *      True if the post is published
     */
    private $published;

    /**
     * @var \DateTime
     *      The date the post was published
     */
    private $datePublished;

    /**
     * @return string
     *      The title of the post
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *      The new title to set for the post
     * @return \Blog\Lib\Post
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     *      The body of the post
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     *      The body of the post to set
     * @return \Blog\Lib\Post
     */
    public function setBody(string $body)
    {
        $this->body = $body;
        return $this;
    }
}
