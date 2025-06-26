<?php

namespace App\Adapter\Secondary\Gateway\Repository\Doctrine;

use App\BusinessLogic\Gateway\Repository\QuestionRepositoryInterface;
use App\BusinessLogic\Model\Game;
use App\BusinessLogic\Model\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class QuestionRepository extends ServiceEntityRepository implements QuestionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    public function save(Question $question): void
    {
        $this->getEntityManager()->persist($question);
        $this->getEntityManager()->flush();
    }

    public function all(): array
    {
        return $this->all();
    }

    public function allByGame(Game $game): array
    {
        $qb = $this->createQueryBuilder('q')
            ->join('q.quiz', 'qz')
            ->join(Game::class, 'g', 'WITH', 'g.quiz = qz')
            ->where('g = :game')
            ->orderBy('q.id', 'ASC')
            ->setParameter('game', $game)
        ;

        return $qb->getQuery()->getResult();
    }
}
