<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    // creer une methode pour recuperer la liste des villes (sans doublons) de la table Annonce

    /**
     * @return Annonce[] Returns an array of Annonce objects
     */
    public function distinctVille()
    {
        return $this->createQueryBuilder('annonce')
            ->select('annonce.ville')
            ->distinct(true)
            ->orderBy('annonce.ville', 'ASC')
        //  ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;

        //// version avec EntityManager
        //  $entityManager = $this->getEntityManager();
        //  $requete = $entityManager->createQuery("SELECT DISTINCT a.ville FROM App\Entity\Annonce a ORDER BY a.ville");
        //  return $requete->getResult();

    }

    public function topAnnonce()
    {
        return $this->createQueryBuilder('annonce')
            ->select('annonce.titre, annonce.date_enregistrement')
            ->orderBy('annonce.date_enregistrement', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
            ;

        //SELECT `titre`,`date_enregistrement` FROM `annonce` ORDER BY `date_enregistrement`ASC LIMIT 5


    }

//    public function topCat()
//    {
//        return $this->createQueryBuilder('annonce')
//            ->select('annonce.titre')
//            ->groupBy('annonce.categorie_id', 'ASC')
//            ->setMaxResults(5)
//            ->getQuery()
//            ->getResult()
//            ;
//
//        //SELECT `categorie_id_id` FROM `annonce` GROUP BY categorie_id_id
//
//
//    }





    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annonce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
