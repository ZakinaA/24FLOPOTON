<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Eleve;  // Importation correcte de l'entité Eleve

/**
 * @extends ServiceEntityRepository<Cours>
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

    //    /**
    //     * @return Cours[] Returns an array of Cours objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Cours
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findByEleve(Eleve $eleve)
    {
        return $this->createQueryBuilder('c')
            ->join('c.inscriptions', 'i') // Assurez-vous que l'entité Cours est liée à l'entité Inscription
            ->where('i.eleve = :eleve')
            ->setParameter('eleve', $eleve)
            ->getQuery()
            ->getResult(); // Utilisez getResult() pour retourner plusieurs résultats
    }


}
