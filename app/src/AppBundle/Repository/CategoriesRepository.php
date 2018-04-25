<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;


/**
 * Class CategoriesRepository
 * @package EntityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoriesRepository extends EntityRepository
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
        $paginator->setMaxPerPage(Category::NUM_ITEMS);
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
        return $this->createQueryBuilder('category');
    }

    /**
     * Save entity.
     *
     * @param Category category Category entity
     */
    public function save(Category $category)
    {
        $this->_em->persist($category);
        $this->_em->flush();
    }

 /**
     * Delete entity.
     *
     * @param \AppBundle\Entity\Category $category Category entity
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Category $category)
    {
        $this->_em->remove($category);
        $this->_em->flush();
    }
}
