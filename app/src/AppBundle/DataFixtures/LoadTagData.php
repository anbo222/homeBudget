<?php
/**
 * Data fixtures for tags.
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadTagData.
 */
class LoadTagData extends Fixture
{
    /**
     * Load tags.
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager Object manager
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            'Git',
            'Google',
            'Symfony',
            'Twig',
            'Silex',
            'Doctrine',
        ];

        foreach ($data as $item) {
            $tag = new Tag();
            $tag->setName($item);
            $manager->persist($tag);
        }
        $manager->flush();
    }
}
