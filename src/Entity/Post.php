<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")      
     * @ORM\Column(type="string", length=36) 
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    private $datetime;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comment")
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     */
    private $user;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $content;

    public function __construct()
    {
        $this->datetime = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function getComments(): ?Comment
    {
        return $this->comments;
    }

    public function setComments(?Comment $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
