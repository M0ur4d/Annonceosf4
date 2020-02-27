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

     /**
      * @return Categorie[] Returns an array of Categorie objects
      */
    public function topCat()
    {
        return $this->createQueryBuilder('c')
            ->select('c.titre')
            ->join("c.categorie_id","a")
            ->groupBy('c.id', 'ASC')
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









    //        $requete = $this->createQueryBuilder('n')
//            ->select("AVG(n.note)")
//            ->join("n.membre_note", "m")
//            ->where("m.id = :id")
//            ->groupBy('m.id')
//            ->setParameter("id", $id_membre)
//            ->getQuery()
//            ->getResult();
//        return !empty($requete) ? $requete[0][1] : null;

    /*
     * SELECT AVG(n.note)
     * FROM note n JOIN user m ON n.membre_note_id = m.id
     * WHERE m.id = $id_membre
     * GROUP BY m.id
     */


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
