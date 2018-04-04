<?php
/**
 * Bookmarks controller.
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Bookmark;
use AppBundle\Form\BookmarkType;
use AppBundle\Repository\BookmarksRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BookmarksController.
 *
 * @package AppBundle\Controller
 *
 * @Route("/bookmarks")
 */
class BookmarksController extends Controller
{
    /**
     * Bookmarks repository.
     *
     * @var \AppBundle\Repository\BookmarksRepository|null Bookmark repository
     */
    protected $bookmarksRepository = null;

    /**
     * BookmarksController constructor.
     *
     * @param \AppBundle\Repository\BookmarksRepository $bookmarksRepository Bookmark repository
     */
    public function __construct(BookmarksRepository $bookmarksRepository)
    {
        $this->bookmarksRepository = $bookmarksRepository;
    }

    /**
     * Index action.
     *
     * @param integer $page Current page number
     *
     * @Route(
     *     "/",
     *     defaults={"page": 1},
     *     name="bookmarks_index",
     * )
     * @Route(
     *     "/page/{page}",
     *     requirements={"page": "[1-9]\d*"},
     *     name="bookmarks_index_paginated",
     * )
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     */
    public function indexAction($page)
    {
        $bookmarks = $this->bookmarksRepository->findAllPaginated($page);

        return $this->render(
            'bookmarks/index.html.twig',
            ['bookmarks' => $bookmarks]
        );
    }

    /**
     * View action.
     *
     * @param Bookmark $bookmark Bookmark entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}",
     *     requirements={"id": "[1-9]\d*"},
     *     name="bookmarks_view",
     * )
     * @Method("GET")
     */
    public function viewAction(Bookmark $bookmark)
    {
        return $this->render(
            'bookmarks/view.html.twig',
            ['bookmark' => $bookmark]
        );
    }

    /**
     * Add action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP Request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/add",
     *     name="bookmarks_add",
     * )
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $tag = new Tag();
        $form = $this->createForm(BookmarkType::class, $bookmark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bookmarksRepository->save($bookmark);
            $this->addFlash('success', 'message.created_successfully');

            return $this->redirectToRoute('bookmarks_index');
        }

        return $this->render(
            'bookmarks/add.html.twig',
            [
                'bookmark' => $bookmark,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request   HTTP      Request
     * @param \AppBundle\Entity\Bookmark                $bookmark  Bookmark  entity
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     requirements={"id": "[1-9]\d*"},
     *     name="bookmarks_edit",
     * )
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Bookmark $bookmark)
    {
        $form = $this->createForm(BookmarkType::class, $bookmark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bookmarksRepository->save($bookmark);
            $this->addFlash('success', 'message.modified_successfully');

            return $this->redirectToRoute('bookmarks_index');
        }

        return $this->render(
            'bookmarks/edit.html.twig',
            [
                'bookmark' => $bookmark,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request   HTTP      Request
     * @param \AppBundle\Entity\Tag                     $bookmark  Bookmark  entity
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     requirements={"id": "[1-9]\d*"},
     *     name="bookmarks_delete",
     * )
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, Bookmark $bookmark)
    {
        $form = $this->createForm(FormType::class, $bookmark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bookmarksRepository->delete($bookmark);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('bookmarks_index');
        }

        return $this->render(
            'bookmarks/delete.html.twig',
            [
                'bookmark' => $bookmark,
                'form' => $form->createView(),
            ]
        );
    }
}
