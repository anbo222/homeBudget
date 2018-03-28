<?php
/**
 * Tags controller.
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Tag;
use AppBundle\Repository\TagsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class TagsController.
 *
 * @Route("/tags")
 */
class TagsController extends Controller
{
    /**
     * Tags repository.
     *
     * @var \AppBundle\Repository\TagsRepository|null $tagsRepository
     */
    protected $tagsRepository = null;

    /**
     * TagsController constructor.
     *
     * @param \AppBundle\Repository\TagsRepository $tagsRepository Tags repository
     */
    public function __construct(TagsRepository $tagsRepository)
    {
        $this->tagsRepository = $tagsRepository;
    }

    /**
     * Index action.
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/",
     *     name="tags_index",
     * )
     * @Method("GET")
     */
    public function indexAction()
    {
        $tags = $this->tagsRepository->findAll();

        return $this->render(
            'tags/index.html.twig',
            ['tags' => $tags]
        );
    }

    /**
     * View action.
     *
     * @param Tag $tag Tag entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}",
     *     requirements={"id": "[1-9]\d*"},
     *     name="tags_view",
     * )
     * @Method("GET")
     */
    public function viewAction(Tag $tag)
    {
        return $this->render(
            'tags/view.html.twig',
            ['tag' => $tag]
        );
    }
}
