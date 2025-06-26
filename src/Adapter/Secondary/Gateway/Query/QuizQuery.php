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

    public function getWithQuestionsCount(string $token): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('token', 'token');
        $rsm->addScalarResult('name', 'name');
        $rsm->addScalarResult('questionsCount', 'questionsCount', 'integer');

        $query = $this->entityManager->createNativeQuery('
            SELECT q.token AS token, q.name AS name, COUNT(qs.id) AS questionsCount
            FROM quiz q
            INNER JOIN question qs ON q.id = qs.quiz_id
            WHERE q.token = ?
        ', $rsm);

        $query->setParameter(1, $token);

        return $query->getResult();
    }
}
