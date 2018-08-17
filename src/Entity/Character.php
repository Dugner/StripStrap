<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CharacterRepository")
 * @ORM\Table("usercharacter")
 */
class Character
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")      
     * @ORM\Column(type="string", length=36) 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * Assert\Length(min=1, max=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $level;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="characters")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="characters")
     */
    private $game;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Document", cascade={"persist", "remove"})
     */
    private $picture;

    /**
     * @ORM\Column(type="text")
     */
    private $detail;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->game = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }


    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setCharacters($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getCharacters() === $this) {
                $user->setCharacters(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGame(): Collection
    {
        return $this->game;
    }

    public function addGame(Game $game): self
    {
        if (!$this->game->contains($game)) {
            $this->game[] = $game;
            $game->setCharacters($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->game->contains($game)) {
            $this->game->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getCharacters() === $this) {
                $game->setCharacters(null);
            }
        }

        return $this;
    }

    public function getPicture(): ?Document
    {
        return $this->picture;
    }

    public function setPicture(?Document $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
