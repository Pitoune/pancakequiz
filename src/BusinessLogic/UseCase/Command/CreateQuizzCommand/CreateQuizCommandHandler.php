<?php

namespace App\BusinessLogic\UseCase\Command\CreateQuizzCommand;

use App\BusinessLogic\Gateway\Provider\StringProviderInterface;
use App\BusinessLogic\Gateway\Repository\QuizRepositoryInterface;
use App\BusinessLogic\Model\Quiz;

class CreateQuizCommandHandler
{
    private QuizRepositoryInterface $quizRepository;

    private StringProviderInterface $stringProvider;

    public function __construct(QuizRepositoryInterface $quizRepository, StringProviderInterface $stringProvider)
    {
        $this->quizRepository = $quizRepository;
        $this->stringProvider = $stringProvider;
    }

    public function handle(CreateQuizCommandRequest $request): Quiz
    {
        $token = $this->stringProvider->random(20);
        $quiz = Quiz::create($token, $request->name, $request->questionsPerParticipant);
        $this->quizRepository->save($quiz);

        return $quiz;
    }
}
