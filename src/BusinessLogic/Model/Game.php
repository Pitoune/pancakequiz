<?php

namespace App\BusinessLogic\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;
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

    #[OneToOne(targetEntity: 'Question', fetch: 'LAZY')]
    private ?Question $currentQuestion = null;

    #[ORM\Column(type: 'bigint', nullable: true)]
    private ?int $lastQuestionTime = null;

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

    public function getCurrentQuestion(): ?Question
    {
        return $this->currentQuestion;
    }

    public function setCurrentQuestion(?Question $currentQuestion): void
    {
        $this->lastQuestionTime = floor(microtime(true) * 1000);
        $this->currentQuestion = $currentQuestion;
    }

    public function getLastQuestionTime(): ?int
    {
        return $this->lastQuestionTime;
    }

    public function setLastQuestionTime(?int $lastQuestionTime): void
    {
        $this->lastQuestionTime = $lastQuestionTime;
    }

    public function addPlayer(string $username): Player
    {
        return new Player(null, $this, $username);
    }
}
