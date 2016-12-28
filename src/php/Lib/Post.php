<?php

namespace Blog\Lib;

use DateTime;

class Post
{
    /**
     * @var string
     *      The title of the post
     */
    private $title;

    /**
     * @var string
     *      The slug of the post for the URI
     */
    private $slug;

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
     *      The slug for the post
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *      The slug for the post
     * @return \Blog\Lib\Post
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @param string $title
     *      The title of the post
     * @param int $length
     *      How long the slug should be
     * @return string
     *      The slug version of the title
     */
    public function createSlug(string $title, int $length = 0): string
    {
        $title = preg_replace('/\s/', '_', $title);
        $title = preg_replace('/\W/', '', $title);

        if ($length) {
            $title = substr($title, 0, $length);
        }

        return strtolower($title);
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

    /**
     * @return bool
     *      Returns whether or not the post is published
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * Sets the published flag for the post.
     *
     * @return \Blog\Lib\Post
     */
    public function publish()
    {
        $this->published = true;
        $this->datePublished = new DateTime();
        return $this;
    }

    /**
     * Unsets the published flag for the post.
     *
     * @return \Blog\Lib\Post
     */
    public function unpublish()
    {
        $this->published = false;
        return $this;
    }

    /**
     * @return \DateTime
     *      The DateTime object for when the post was published
     */
    public function getDatePosted(): DateTime
    {
        return $this->datePublished;
    }

    /**
     * @param |DateTime $date
     *      A DateTime object representing when the post was published
     */
    public function setDatePublished(DateTime $date)
    {
        $this->datePublished = $date;
        return $this;
    }
}
