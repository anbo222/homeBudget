<?php
/**
 * Data fixtures for tags.
 */

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Bookmark;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadBookmarkData.
 */
class LoadBookmarkData extends Fixture
{
    /**
     * Load bookmarks.
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
            $bookmark = new Bookmark();
            $bookmark->setName($item);
            $manager->persist($bookmark);
        }
        $manager->flush();
    }
}
