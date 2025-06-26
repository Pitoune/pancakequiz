<?php

namespace App\BusinessLogic\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity]
class Question
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ManyToOne(targetEntity: 'Quiz', fetch: 'LAZY')]
    private Quiz $quiz;

    #[ORM\Column(type: 'string')]
    private string $question;

    #[ORM\Column(type: 'string')]
    private string $correctAnswer;

    #[ORM\Column(type: 'json')]
    private array $answers;

    public function __construct(
        ?int $id,
        Quiz $quiz,
        string $question,
        string $correctAnswer,
        array $answers,
    ) {
        $this->id = $id;
        $this->quiz = $quiz;
        $this->question = $question;
        $this->correctAnswer = $correctAnswer;
        $this->answers = $answers;
    }

    public static function create(
        Quiz $quiz,
        string $question,
        string $correctAnswer,
        array $answers,
    ): self {
        return new self(
            null,
            $quiz,
            $question,
            $correctAnswer,
            $answers,
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuiz(): Quiz
    {
        return $this->quiz;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function getCorrectAnswer(): string
    {
        return $this->correctAnswer;
    }

    public function getAnswers(): array
    {
        return $this->answers;
    }
}
