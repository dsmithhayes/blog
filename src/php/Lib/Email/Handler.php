<?php

namespace Blog\Lib\Email;

use Extended\Process\Fork;
use Extended\Process\Runnable;
use Extended\Exception\ProcessException;
use Blog\Lib\Email\Headers;

class Handler
{
    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $message;

    /**
     * @var \Blog\Lib\Email\Headers
     *      Collection of headers for the email that is being sent
     */
    private $headers;

    /**
     * @param string $subject
     * @param string $message
     * @param Blog\Lib\Email\Headers|null $headers
     */
    public function __construct(string $subject,
                                string $message,
                                $headers = null
    ) {
        if (!$headers) {
            $headers = new Headers();
        }

        $this->setSubject($subject)
             ->setMessage($message)
             ->setHeaders($headers);
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param Blog\Lib\Email\Headers $headers
     * @return Blog\Lib\Email\Handler
     */
    public function setHeaders(Headers $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return Blog\Lib\Email\Headers
     */
    public function getHeaders(): Headers
    {
        return $this->headers;
    }

    /**
     * Wraps PHP's internal `mail` function with the attributes in this object.
     *
     * @return bool
     */
    public function send(): bool
    {
        try {
            $mailProcess = new class ($this->subject,
                                      $this->message,
                                      $this->headers) extends Runnable
            {
                protected $subject;
                protected $message;
                protected $headers;

                public function __construct(string $subject,
                                            string $message,
                                            Headers $headers)
                {
                    $this->subject = $subject;
                    $this->message = $message;
                    $this->heades = $headers;
                }

                public function run()
                {
                    return mail('me@davesmithhayes.com',
                                $this->subject,
                                $this->message,
                                (string) $this->headers);
                }
            };

            $fork = (new Fork())->fork($mailProcess);

        } catch (ProcessException $pe) {
            return false;
        }

        return true;
    }
}
