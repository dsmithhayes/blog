<?php

namespace Blog\Lib;

class Contact
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $message;

    /**
     * @param string $name
     * @param string $email
     * @param string $subject
     * @param string $message
     */
    public function __construct(string $name,
                                string $email,
                                string $subject,
                                string $message
    ) {
        $this->setName($name)
             ->setEmail($email)
             ->setSubject($subject)
             ->setMessage($message);
    }

    /**
     * @param string $name
     *      The name of the sender
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     *      The name of the sender
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $email
     *      The email address of the sender
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     *      The email set for the sender
     */
    public function getEmail(): string
    {
        return $this->emai;
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
     * Performs the actual sending of the email
     */
    public function send(): bool
    {

        return false;
    }
}
