<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\News;
use App\Entity\Viewers;
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
        parent::__construct($registry, Viewers::class);
    }

    public function getViewersCountries($newsId)
    {
        $connection = $this->_em->getConnection();
        $sql = "SELECT DISTINCT(country) FROM viewers WHERE news = $newsId";
        $statement = $connection->prepare($sql);
        $result = $statement->executeQuery();
        return $result->fetchAllAssociative();
    }

    public function getDurationAndPercentage($newsId, $country)
    {
        $connection = $this->_em->getConnection();
        $sql = "SELECT AVG(duration) duration, AVG(readpercentage) readpercentage FROM viewers WHERE country =\"$country\" and  news = $newsId";
        $statement = $connection->prepare($sql);
        $result = $statement->executeQuery();
        return $result->fetchAssociative();
    }

    public function getMonthViewers($newsId, $month, $year)
    {
        $connection = $this->_em->getConnection();
        if($month != null)
            $sql = "SELECT *, DAY(createdat) dayy FROM viewers WHERE MONTH(createdat) = $month AND YEAR(createdat) = $year AND news = $newsId ORDER BY DAY(createdat)";
        else
            $sql = "SELECT *, DAY(createdat) dayy FROM viewers WHERE MONTH(createdat) = MONTH(NOW()) AND YEAR(createdat) = YEAR(NOW()) AND news = $newsId ORDER BY DAY(createdat)";
        $statement = $connection->prepare($sql);
        $result = $statement->executeQuery();
        return $result->fetchAllAssociative();
    }

    public function getYears($newsId)
    {
        $connection = $this->_em->getConnection();
        $sql = "SELECT DISTINCT YEAR(createdat) yearr FROM viewers WHERE news = $newsId";
        $statement = $connection->prepare($sql);
        $result = $statement->executeQuery();
        return $result->fetchAllAssociative();
    }

    public function getMonths($newsId)
    {
        $connection = $this->_em->getConnection();
        $sql = "SELECT DISTINCT MONTH(createdat) monthh FROM viewers WHERE news = $newsId";
        $statement = $connection->prepare($sql);
        $result = $statement->executeQuery();
        return $result->fetchAllAssociative();
    }

}
