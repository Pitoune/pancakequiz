<?php

namespace App\Adapter\Secondary\Gateway\Query;

use App\BusinessLogic\Gateway\Query\QuizQueryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;

class QuizQuery implements QuizQueryInterface
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
        $rsm->addScalarResult('gameToken', 'gameToken');

        $query = $this->entityManager->createNativeQuery('
            SELECT q.token AS token, q.name AS name, COUNT(qs.id) AS questionsCount, g.token AS gameToken
            FROM quiz q
            LEFT JOIN question qs ON q.id = qs.quiz_id
            LEFT JOIN game g ON g.quiz_id = q.id
            WHERE q.token = ?
            GROUP BY q.id
        ', $rsm);

        $query->setParameter(1, $token);

        return $query->getResult();
    }
}
