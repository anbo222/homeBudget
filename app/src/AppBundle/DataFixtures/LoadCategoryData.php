<?php
/**
 * Data fixtures for categories.
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadCategoryData.
 */
class LoadCategoryData extends Fixture
{
    /**
     * Load categories.
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager Object manager
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            '1',
            '2',
            '3',
            '4',
            '5',
        ];

        foreach ($data as $item) {
            $category = new Category();
            $category->setName($item);
            $manager->persist($category);
        }
        $manager->flush();
    }
}
