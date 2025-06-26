<?php

namespace App\BusinessLogic\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity]
class Game
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $token;

    #[ManyToOne(targetEntity: 'Quiz', fetch: 'LAZY')]
    private Quiz $quiz;

    public function __construct(?int $id, string $token, Quiz $quiz)
    {
        $this->id = $id;
        $this->token = $token;
        $this->quiz = $quiz;
    }

    public static function create(string $token, Quiz $quiz): self
    {
        return new self(null, $token, $quiz);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getQuiz(): Quiz
    {
        return $this->quiz;
    }

    public function addPlayer(string $username): Player
    {
        return new Player(null, $this, $username);
    }
}
