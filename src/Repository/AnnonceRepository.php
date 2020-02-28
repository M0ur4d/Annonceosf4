<?php

namespace App\Repository;

use App\Entity\User;
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
        return $this->createQueryBuilder('a')
            ->select('annonce.titre, annonce.date_enregistrement')
            ->orderBy('a.date_enregistrement', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
            ;

        //SELECT `titre`,`date_enregistrement` FROM `annonce` ORDER BY `date_enregistrement`ASC LIMIT 5


    }

    public function findTop5MembresActifs()
    {
        $resultat = $this->createQueryBuilder('a')
            ->select("u.id, u.pseudo, COUNT(a.membre_id) nb")
            ->join("a.membre_id", "u")
            ->groupBy("u.id")
            ->orderBy("nb", "DESC")
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        return $resultat;

// SELECT u.id, u.pseudo, COUNT(a.membre_id_id) Nb
// FROM user u JOIN annonce a ON a.membre_id_id=u.id
// GROUP BY membre_id_id
// ORDER BY Nb DESC
    }

    /**
     * Top Categories
     */
    public function topCat()
    {
        return $this->createQueryBuilder('a')
            ->select('c.titre, COUNT(c.id) nb')
            ->join("a.categorie_id", "c")
            ->groupBy('c.id')
            ->orderBy("nb", "DESC")
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
            ;
        //select categorie.titre
        //from categorie join annonce on categorie.id=annonce.categorie_id_id
        //group by categorie.id

        //select c.titre
        //from categorie c join annonce a on c.id=a.categorie_id_id
        //group by c.id
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
