<?php

namespace App\BusinessLogic\UseCase\Command\RecordAnswerCommand;

use App\BusinessLogic\Gateway\Repository\GameRepositoryInterface;
use App\BusinessLogic\Gateway\Repository\PlayerRepositoryInterface;
use App\BusinessLogic\Service\PlayerContext;
use App\BusinessLogic\Service\ScoreCalculator;

class RecordAnswerCommandHandler
{
    private PlayerContext $playerContext;

    private PlayerRepositoryInterface $playerRepository;

    private GameRepositoryInterface $gameRepository;

    private ScoreCalculator $scoreCalculator;

    public function __construct(
        PlayerContext $playerContext,
        PlayerRepositoryInterface $playerRepository,
        GameRepositoryInterface $gameRepository,
        ScoreCalculator $scoreCalculator,
    ) {
        $this->playerContext = $playerContext;
        $this->playerRepository = $playerRepository;
        $this->gameRepository = $gameRepository;
        $this->scoreCalculator = $scoreCalculator;
    }

    public function handle(RecordAnswerCommandRequest $request): void
    {
        $player = $this->playerContext->getPlayer();

        if ($player->hasAnswered()) {
            return;
        }

        $game = $this->gameRepository->get($player->getGame()->getId());

        if ($game->getCurrentQuestion()->getCorrectAnswer() == $request->answer) {
            $milliseconds = floor(microtime(true) * 1000);
            $score = $this->scoreCalculator->calculate($game->getLastQuestionTime(), $milliseconds);
            $player->updateScore($score);
        }

        $player->setAnswered(true);
        $this->playerRepository->save($player);
    }
}
