<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }


//    /**
//     *  Recherche pour un mot dans le barre de recherche
//     */
//    public function recherche($mot)
//    {
//        return $this->createQueryBuilder("c")
//            ->where("c.titre LIKE :mot or c.motscles LIKE :mot")
//            ->setParameter("mot", "%$mot%")
//            ->getQuery()
//            ->getResult()
//            ;
//
//        //SELECT *
//        //FROM categorie c
//        //WHERE c.titre LIKE "%job%" OR c.motscles LIKE "%job%"
//    }

     /**
      *  Recherche plusieurs mots dans le barre de recherche
      */
    public function recherche($phrase)
    {
        $mots = explode(" ", $phrase);
        $where = "";
        foreach ($mots as $indice => $mot) {
            $where .= ($where ? " OR " : "") . "c.titre LIKE :mot$indice OR c.motscles LIKE :mot$indice";
        }

        $resultat = $this->createQueryBuilder("c")
            ->where($where);
        foreach ($mots as $indice => $mot) {
            $resultat->setParameter("mot$indice", $mot);
        }

        return $resultat->getQuery()->getResult();
    }







    // /**
    //  * @return Categorie[] Returns an array of Categorie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Categorie
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
