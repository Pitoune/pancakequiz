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

    #[ORM\Column(type: 'boolean')]
    private bool $answered = false;

    #[ORM\Column(type: 'integer')]
    private int $score = 0;

    public function __construct(?int $id, Game $game, string $username, bool $answered = false, int $score = 0)
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

    public function hasAnswered(): bool
    {
        return $this->answered;
    }

    public function setAnswered(bool $answered): void
    {
        $this->answered = $answered;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function updateScore(int $score): void
    {
        $this->score += $score;
    }
}
