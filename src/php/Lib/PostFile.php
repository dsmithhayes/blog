<?php

namespace Blog\Lib;

use PDO;
use Parsedown;

class PostFile
{
    /**
     * @var string
     *      The title of the post
     */
    private $title;

    /**
     * @var string
     *      The file contents buffer
     */
    private $buffer;

    /**
     * @var \Blog\Lib\Database\Model
     *      And instance of the Post model
     */
    private $model

    /**
     * @var \Parsedown
     *      The markdown parser
     */
    private $parser;

    /**
     * @param string $filePath
     *      The full file path of the post file
     */
    public function __construct(string $filePath, pdo $pdo)
    {
        $this->buffer = file_get_contents($filePath);
        $this->model  = new Model('posts', $pdo);
        $this->parser = new Parsedown();

        $firstLine = explode('\n', $this->buffer)[0];
        
        if ($firstLine[0] === '#') {
            $firstLine = substr($firstLine, 2);
        }

        $this->title = $firstLine;

        // If the post doesn't exist in the database yet.
        if (!$this->model->findBy('title', $this->title)) {

        }
    }

    /**
     * @return string
     *      The title of the post
     */
    public function getTitle(): string
    {
        return $this->title
    }

    /**
     * @return string
     *      The rendered HTML from the markdown post
     */
    public function render(): string
    {
        return $this->parser->text($this->buffer);
    }
}
