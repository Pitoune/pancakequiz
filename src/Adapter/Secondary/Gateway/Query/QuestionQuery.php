<?php

namespace App\Adapter\Secondary\Gateway\Query;

use App\BusinessLogic\Gateway\Query\QuestionQueryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;

class QuestionQuery implements QuestionQueryInterface
{
    private readonly EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get(int $id): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('question', 'question');
        $rsm->addScalarResult('correctAnswer', 'correctAnswer');
        $rsm->addScalarResult('answers', 'answers', 'json');

        $query = $this->entityManager->createNativeQuery('
            SELECT q.question AS question, q.correct_answer AS correctAnswer, q.answers AS answers
            FROM question q
            WHERE q.id = ?
        ', $rsm);

        $query->setParameter(1, $id);

        return $query->getResult()[0];
    }
}
