<?php

namespace App\BusinessLogic\Model;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity]
class Quiz
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $token;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'integer')]
    private int $questionsPerParticipant;

    public function __construct(?int $id, string $token, string $name, int $questionsPerParticipant)
    {
        $this->id = $id;
        $this->token = $token;
        $this->name = $name;
        $this->questionsPerParticipant = $questionsPerParticipant;
    }

    public static function create(string $token, string $name, int $questionsPerParticipant): Quiz
    {
        return new self(null, $token, $name, $questionsPerParticipant);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getQuestionsPerParticipant(): int
    {
        return $this->questionsPerParticipant;
    }

    public function addQuestion(string $question, string $correctAnswer, array $answers): Question
    {
        return Question::create($this, $question, $correctAnswer, $answers);
    }

    public function addGame(string $token): Game
    {
        return Game::create($token, $this);
    }
}
