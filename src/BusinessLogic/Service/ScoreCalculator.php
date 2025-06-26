<?php

namespace App\BusinessLogic\Service;

class ScoreCalculator
{
    private const int TOP_SCORE = 1000;
    private const int TIME_FOR_TOP_SCORE = 3000; // 3 seconds
    private const int TIME_FOR_MIN_SCORE = 30000; // 30 seconds

    public function calculate(int $questionTime, int $answerTime): int
    {
        $diff = $answerTime - $questionTime;
        if ($diff < self::TIME_FOR_TOP_SCORE) {
            return self::TOP_SCORE;
        }

        return (int) round((self::TIME_FOR_MIN_SCORE + self::TIME_FOR_TOP_SCORE - $diff) / self::TIME_FOR_MIN_SCORE * self::TOP_SCORE);
    }
}
