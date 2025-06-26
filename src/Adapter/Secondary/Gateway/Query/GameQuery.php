<?php

namespace App\Adapter\Secondary\Gateway\Query;

use App\BusinessLogic\Gateway\Query\GameQueryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;

class GameQuery implements GameQueryInterface
{
    private readonly EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getByToken(string $token): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('token', 'token');
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('questionsCount', 'questionsCount', 'integer');
        $rsm->addScalarResult('players', 'players');
        $rsm->addScalarResult('currentQuestion', 'currentQuestion', 'integer');

        $query = $this->entityManager->createNativeQuery('
            SELECT g.token AS token, q.name AS name, COUNT(qs.id) AS questionsCount, GROUP_CONCAT(DISTINCT p.username) AS players, g.current_question_id AS currentQuestion
            FROM game g
            INNER JOIN quiz q ON g.quiz_id = q.id
            LEFT JOIN question qs ON q.id = qs.quiz_id
            LEFT JOIN player p ON p.game_id = g.id
            WHERE g.token = ?
            GROUP BY g.id
        ', $rsm);

        $query->setParameter(1, $token);

        return $query->getResult();
    }

    public function getScoresByToken(string $token): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('username', 'username');
        $rsm->addScalarResult('score', 'score', 'integer');

        $query = $this->entityManager->createNativeQuery('
            SELECT p.username AS username, p.score AS score
            FROM game g
            INNER JOIN player p ON p.game_id = g.id
            WHERE g.token = ?
            GROUP BY p.id
            ORDER BY p.score DESC
        ', $rsm);

        $query->setParameter(1, $token);

        return $query->getResult();
    }
}
