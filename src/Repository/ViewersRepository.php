<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ViewersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function getViewersCountries()
    {
        $connection = $this->_em->getConnection();
        $sql = "SELECT DISTINCT(country) FROM viewers";
        $statement = $connection->prepare($sql);
        $result = $statement->executeQuery();
        return $result->fetchAssociative();
    }

    public function getDurationAndPercentage($country)
    {
        $connection = $this->_em->getConnection();
        $sql = "SELECT AVG(duration) duration, AVG(readpercentage) readpercentage FROM viewers WHERE country =\"$country\"";
        $statement = $connection->prepare($sql);
        $result = $statement->executeQuery();
        return $result->fetchAssociative();
    }

    public function getMonthViewers($month, $year)
    {
        $connection = $this->_em->getConnection();
        if($month != null)
            $sql = "SELECT *, DAY(createdat) dayy FROM viewers WHERE MONTH(createdat) = $month AND YEAR(createdat) = $year ORDER BY DAY(createdat)";
        else
            $sql = "SELECT *, DAY(createdat) dayy FROM viewers WHERE MONTH(createdat) = MONTH(NOW()) AND YEAR(NOW()) = $year ORDER BY DAY(createdat)";
        $statement = $connection->prepare($sql);
        $result = $statement->executeQuery();
        return $result->fetchAssociative();
    }

    public function getYears()
    {
        $connection = $this->_em->getConnection();
        $sql = "SELECT DISTINCT YEAR(createdat) FROM viewers";
        $statement = $connection->prepare($sql);
        $result = $statement->executeQuery();
        return $result->fetchOne();
    }

    public function getMonths()
    {
        $connection = $this->_em->getConnection();
        $sql = "SELECT DISTINCT MONTH(createdat) FROM viewers";
        $statement = $connection->prepare($sql);
        $result = $statement->executeQuery();
        return $result->fetchOne();
    }

}
