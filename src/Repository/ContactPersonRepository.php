<?php

namespace App\Repository;

use App\Entity\ContactPerson;
use App\Repository\Traits\UuidFinderTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContactPerson>
 *
 * @method ContactPerson|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactPerson|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactPerson[]    findAll()
 * @method ContactPerson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactPersonRepository extends ServiceEntityRepository
{
    use UuidFinderTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactPerson::class);
    }

    public function save(ContactPerson $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ContactPerson $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ContactPerson[] Returns an array of ContactPerson objects
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

//    public function findOneBySomeField($value): ?ContactPerson
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
