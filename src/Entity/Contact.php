<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * Undocumented variable
     *
     * @var string|null
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * Undocumented variable
     *
     * @var string|null
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * Undocumented variable
     *
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Regex(
     * pattern = "/[0-9]{10}/")
     */
    private $phone;

    /**
     * Undocumented variable
     *
     * @var string|null
     */
    private $email;

    /**
     * Undocumented variable
     *
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=10)
     */
    private $message;


    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $firstname  Undocumented variable
     *
     * @return  self
     */
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $lastname  Undocumented variable
     *
     * @return  self
     */
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $phone  Undocumented variable
     *
     * @return  self
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $email  Undocumented variable
     *
     * @return  self
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $message  Undocumented variable
     *
     * @return  self
     */
    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }
}
