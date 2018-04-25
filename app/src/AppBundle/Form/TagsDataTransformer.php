<?php
/**
 * Tags data transformer.
 */
namespace AppBundle\Form;

use AppBundle\Entity\Tag;
use AppBundle\Repository\TagsRepository;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class TagsDataTransformer.
 */
class TagsDataTransformer implements DataTransformerInterface
{
    /**
     * Tag repository.
     *
     * @var TagsRepository|null $tagsRepository
     */
    protected $tagsRepository = null;

    /**
     * TagsDataTransformer constructor.
     *
     * @param TagsRepository $tagsRepository Tags repository
     */
    public function __construct(TagsRepository $tagsRepository)
    {
        $this->tagsRepository = $tagsRepository;
    }

    /**
     * Transform array of tags to string of names.
     *
     * @param array $tags Tags entity array
     *
     * @return string Result
     */
    public function transform($tags)
    {
        if (null == $tags) {
            return '';
        }

        $tagNames = [];

        foreach ($tags as $tag) {
            $tagNames[] = $tag->getName();
        }

        return implode(',', $tagNames);
    }

    /**
     * Transform string of tag names into array of Tag entities.
     *
     * @param string $string String of tag names
     *
     * @return array Result
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function reverseTransform($string)
    {
        $tagNames = explode(',', $string);

        $tags = [];
        foreach ($tagNames as $tagName) {
            if (trim($tagName) !== '') {
                $tag = $this->tagsRepository->findOneByName($tagName);
                if (null == $tag) {
                    $tag = new Tag();
                    $tag->setName($tagName);
                    $this->tagsRepository->save($tag);
                }
                $tags[] = $tag;
            }
        }

        return $tags;
    }
}