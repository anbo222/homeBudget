<?php
/**
 * Bookmark controller.
 */
namespace AppBundle\Controller;

use AppBundle\Repository\BookmarkRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class BookmarkController.
 *
 * @package AppBundle\Controller
 *
 * @Route("/bookmark")
 */
class BookmarkController extends Controller
{
    /**
     * Index action.
     *
     * @Route(
     *     "/",
     *     name="bookmark_index",
     * )
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     */
    public function indexAction()
    {
        $bookmarkRepository = new BookmarkRepository();
        $bookmarks = $bookmarkRepository->findAll();

        return $this->render(
            'bookmark/index.html.twig',
            ['bookmarks' => $bookmarks]
        );
    }

    /**
     * View action.
     *
     * @Route(
     *     "/{id}",
     *     name="bookmark_view",
     * )
     * @Method("GET")
     * @param int $id Id
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     */
    public function viewAction($id)
    {
        $bookmarkRepository = new BookmarkRepository();
        $bookmark = $bookmarkRepository->findOneById($id);

        return $this->render(
            'bookmark/view.html.twig',
            ['bookmark' => $bookmark]
        );
    }
}