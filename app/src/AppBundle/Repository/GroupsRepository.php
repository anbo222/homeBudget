<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Group;
use Doctrine\ORM\EntityRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;


/**
 * Class GroupsRepository
 * @package EntityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GroupsRepository extends EntityRepository
{
    /**
     * Gets all records paginated.
     *
     * @param int $page Page number
     *
     * @return \Pagerfanta\Pagerfanta Result
     */
    public function findAllPaginated($page = 1)
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryAll(), false));
        $paginator->setMaxPerPage(Group::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

 /**
     * Query all entities.
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function queryAll()
    {
        return $this->createQueryBuilder('group');
    }

    /**
     * Save entity.
     *
     * @param Group group Group entity
     */
    public function save(Group $group)
    {
        $this->_em->persist($group);
        $this->_em->flush();
    }

 /**
     * Delete entity.
     *
     * @param \AppBundle\Entity\Group $group Group entity
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Group $group)
    {
        $this->_em->remove($group);
        $this->_em->flush();
    }
}

