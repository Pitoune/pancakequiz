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

    #[ORM\Column(type: 'string')]
    private string $wrongAnswer1;

    #[ORM\Column(type: 'string')]
    private string $wrongAnswer2;

    #[ORM\Column(type: 'string')]
    private string $wrongAnswer3;

    public function __construct(
        ?int $id,
        Quiz $quiz,
        string $question,
        string $correctAnswer,
        string $wrongAnswer1,
        string $wrongAnswer2,
        string $wrongAnswer3,
    ) {
        $this->id = $id;
        $this->quiz = $quiz;
        $this->question = $question;
        $this->correctAnswer = $correctAnswer;
        $this->wrongAnswer1 = $wrongAnswer1;
        $this->wrongAnswer2 = $wrongAnswer2;
        $this->wrongAnswer3 = $wrongAnswer3;
    }

    public static function create(
        Quiz $quiz,
        string $question,
        string $correctAnswer,
        string $wrongAnswer1,
        string $wrongAnswer2,
        string $wrongAnswer3): self
    {
        return new self(
            null,
            $quiz,
            $question,
            $correctAnswer,
            $wrongAnswer1,
            $wrongAnswer2,
            $wrongAnswer3,
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

    public function getWrongAnswer1(): string
    {
        return $this->wrongAnswer1;
    }

    public function getWrongAnswer2(): string
    {
        return $this->wrongAnswer2;
    }

    public function getWrongAnswer3(): string
    {
        return $this->wrongAnswer3;
    }
}
