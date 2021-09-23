<?php

namespace App\Repository;

use App\Entity\News;
use App\Entity\Visitor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visitor::class);
    }

    public function getMonthVisitors()
    {
        $connection = $this->_em->getConnection();
        $sql = "SELECT COUNT(*) visitors FROM visitor WHERE MONTH(createdat)=MONTH(NOW())";
        $statement = $connection->prepare($sql);
        $result = $statement->executeQuery();
        return $result->fetchOne();
    }

    public function getYearVisitors()
    {
        $connection = $this->_em->getConnection();
        $sql = "SELECT COUNT(*) visitors FROM visitor WHERE YEAR(createdat)=YEAR(NOW())";
        $statement = $connection->prepare($sql);
        $result = $statement->executeQuery();
        return $result->fetchOne();
    }

    public function getMonthViewers()
    {
        $connection = $this->_em->getConnection();
        $sql = "SELECT *, DAY(createdat) dayy FROM visitor WHERE MONTH(createdat) = MONTH(NOW()) AND YEAR(createdat) = YEAR(NOW()) ORDER BY DAY(createdat)";
        $statement = $connection->prepare($sql);
        $result = $statement->executeQuery();
        return $result->fetchAllAssociative();
    }
}
