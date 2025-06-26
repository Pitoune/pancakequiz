<?php

namespace App\BusinessLogic\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity]
class Player
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ManyToOne(targetEntity: 'Game', fetch: 'LAZY')]
    private Game $game;

    #[ORM\Column(type: 'string')]
    private string $username;

    public function __construct(?int $id, Game $game, string $username)
    {
        $this->id = $id;
        $this->game = $game;
        $this->username = $username;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGame(): Game
    {
        return $this->game;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
