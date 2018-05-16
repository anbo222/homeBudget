<?php
/**
 * Data fixtures for operations.
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Operation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadBookmarkData.
 */
class LoadOperationData extends Fixture
{
    /**
     * Load operations.
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager Object manager
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            100,
            -32,
            353,
            -403,
            56,
        ];

        foreach ($data as $item) {
            $operation = new Operation();
            $operation->setAmount($item);
            $operation->setCreatedAt('2018-05-08\09:06:00');
            $manager->persist($operation);
        }
        $manager->flush();
    }
}
