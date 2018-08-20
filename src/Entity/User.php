<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\Role;
use App\Entity\Comment;
use App\Entity\UserCharacter;
use App\Entity\Post;
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
     * @ORM\OneToMany(targetEntity="App\Entity\Friend", mappedBy="user")
     */
    private $friends;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role")
     */
    private $roles;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserCharacter", mappedBy="user")
     */
    private $userCharacters;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="user")
     */
    private $posts;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user")
     */
    private $comments;
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Document", cascade={"persist", "remove"})
     */
    private $picture;

    public function __construct()
    {
        $this->friends = new ArrayCollection();
        $this->UserCharacters = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
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
    public function getFriends(): ?Collection
    {
        return $this->friends;
    }
    public function addFriends(Friend $friend): self
    {
        if (!$this->friends->contains($friend)) {
            $this->friends[] = $friend;
            $friend->setUser($this);
        }
        return $this;
    }
    public function removeFriends(Friend $friend): self
    {
        if ($this->friends->contains($friend)) {
            $this->friends->removeElement($friend);
            // set the owning side to null (unless already changed)
            if ($friend->getUser() === $this) {
                $friend->setUser(null);
            }
        }
        return $this;
    }
    /**
     * @return Role[]
     */
    public function getRoles(): array
    {
        return array_map('strval', $this->roles->toArray());
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
    public function getRole()
    {
        return $this->roles;
    }
    public function setRole(array $roles)
    {
        $this->roles = $roles;
        return $this;
    }
    public function getUserCharacters(): ?Collection
    {
        return $this->userCharacters;
    }
    public function addUserCharacters(UserCharacter $userCharacter): self
    {
        if (!$this->userCharacters->contains($userCharacter)) {
            $this->userCharacters[] = $userCharacter;
            $userCharacter->setUser($this);
        }
        return $this;
    }
    public function removeUserCharacters(UserCharacter $userCharacter): self
    {
        if ($this->userCharacters->contains($userCharacter)) {
            $this->userCharacters->removeElement($userCharacter);
            // set the owning side to null (unless already changed)
            if ($userCharacter->getUser() === $this) {
                $userCharacter->setUser(null);
            }
        }
        return $this;
    }

    public function getPosts(): ?Collection
    {
        return $this->posts;
    }
    public function addPosts(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }
        return $this;
    }
    public function removePosts(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }
        return $this;
    }
    public function getComments(): ?Collection
    {
        return $this->comments;
    }
    public function addComments(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $post->setUser($this);
        }
        return $this;
    }
    public function removeComments(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }
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