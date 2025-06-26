<?php

namespace App\BusinessLogic\UseCase\Command\CreateQuizzCommand;

class CreateQuizCommandRequest
{
    public string $name;

    public int $questionsPerParticipant;

    public string $participants;
}
