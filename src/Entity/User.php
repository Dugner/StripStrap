<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\Role;

/**
 * @ORM\Entity()
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")      
     * @ORM\Column(type="string", length=36) 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * Assert\Length(min=3, max=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * Assert\Length(min=3, max=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * Assert\Length(min=8, max=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $country;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    private $dateOfBirth;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Friend", inversedBy="user")
     */
    private $friend;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role")
     */
    private $roles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Character", inversedBy="user")
     */
    private $characters;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="user")
     */
    private $posts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comment", inversedBy="user")
     */
    private $comments;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Document", cascade={"persist", "remove"})
     */
    private $picture;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }


    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getFriend(): ?Friend
    {
        return $this->friend;
    }

    public function setFriend(?Friend $friend): self
    {
        $this->friend = $friend;

        return $this;
    }

    /**
     * @return Collection|Role[]
     */
    public function getRoles(): array
    {
        return array_map('strval',
        $this->roles->toArray());
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }

    public function getCharacters(): ?Character
    {
        return $this->characters;
    }

    public function setCharacters(?Character $characters): self
    {
        $this->characters = $characters;

        return $this;
    }

    public function getPosts(): ?Post
    {
        return $this->posts;
    }

    public function setPosts(?Post $posts): self
    {
        $this->posts = $posts;

        return $this;
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

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture): self
    {
        $this->picture = $picture;

        return $this;
    }
    

    public function eraseCredentials()
    {
      return null;
    }
  
    public function getSalt()
    {
      return null;
    }
}
