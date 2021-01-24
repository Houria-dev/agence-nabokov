<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=10)
     */
    private $message;

     /**
     * @Assert\DateTime
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private $sentAt;
    
    public function getEmail(){
        return $this->email;
    }

    public function getMessage(){
        return $this->message;
    }


    public function setEmail($email){
        $this->email=$email;
    }

    public function setMessage($message){
        $this->message=$message;
    }
    public function getSentAt(): ?\DateTimeInterface
    {
        return $this->sentAt;
    }

    public function setSentAt(\DateTimeInterface $sentAt): self
    {
        $this->sentAt = $sentAt;

        return $this;
    }

}
