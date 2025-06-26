<?php

namespace App\Adapter\Secondary\Gateway\Repository\Doctrine;

use App\BusinessLogic\Gateway\Repository\QuizRepositoryInterface;
use App\BusinessLogic\Model\Quiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class QuizRepository extends ServiceEntityRepository implements QuizRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quiz::class);
    }

    public function save(Quiz $quiz): void
    {
        $this->getEntityManager()->persist($quiz);
        $this->getEntityManager()->flush();
    }

    public function get(int $id): ?Quiz
    {
        return $this->find($id);
    }
}
