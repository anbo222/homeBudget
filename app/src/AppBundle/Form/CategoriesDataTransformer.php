<?php
/**
 * Categories data transformer.
 */
namespace AppBundle\Form;

use AppBundle\Entity\Category;
use AppBundle\Repository\CategoriesRepository;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class CategoriesDataTransformer.
 */
class CategoriesDataTransformer implements DataTransformerInterface
{
    /**
     * Category repository.
     *
     * @var CategoriesRepository|null $categoriesRepository
     */
    protected $categoriesRepository = null;

    /**
     * CategoriesDataTransformer constructor.
     *
     * @param CategoriesRepository $categoriesRepository Categories repository
     */
    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * Transform array of categories to string of names.
     *
     * @param array $categories Categories entity array
     *
     * @return string Result
     */
    public function transform($categories)
    {
        if (null == $categories) {
            return '';
        }

        $categoryNames = [];

        foreach ($categories as $category) {
            $categoryNames[] = $category->getName();
        }

        return implode(',', $categoryNames);
    }

    /**
     * Transform string of category names into array of Category entities.
     *
     * @param string $string String of category names
     *
     * @return array Result
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function reverseTransform($string)
    {
        $categoryNames = explode(',', $string);

        $categories = [];
        foreach ($categoryNames as $categoryName) {
            if (trim($categoryName) !== '') {
                $category = $this->categoriesRepository->findOneByName($categoryName);
                if (null == $category) {
                    $category = new Category();
                    $category->setName($categoryName);
                    $this->categoriesRepository->save($category);
                }
                $categories[] = $category;
            }
        }

        return $categories;
    }
}