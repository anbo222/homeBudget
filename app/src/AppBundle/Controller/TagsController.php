<?php
/**
 * Tags controller.
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Tag;
use AppBundle\Form\TagType;
use AppBundle\Repository\TagsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TagController.
 *
 * @Route(
 *     "/tags"
 * )
 */
class TagsController extends Controller
{
    /**
     * Tag repository.
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
     * @param integer $page Current page number
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/",
     *     defaults={"page": 1},
     *     name="tags_index",
     * )
     * @Route(
     *     "/page/{page}",
     *     requirements={"page": "[1-9]\d*"},
     *     name="tags_index_paginated",
     * )
     * @Method("GET")
     */
    public function indexAction($page)
    {
        $tags = $this->tagsRepository->findAllPaginated($page);

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
     *     name="tags_add",
     * )
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tagsRepository->save($tag);
            $this->addFlash('success', 'message.created_successfully');

            return $this->redirectToRoute('tags_index');
        }

        return $this->render(
            'tags/add.html.twig',
            [
                'tag' => $tag,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP Request
     * @param \AppBundle\Entity\Tag                     $tag     Tag entity
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     requirements={"id": "[1-9]\d*"},
     *     name="tags_edit",
     * )
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tag $tag)
    {
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tagsRepository->save($tag);
            $this->addFlash('success', 'message.modified_successfully');

            return $this->redirectToRoute('tags_index');
        }

        return $this->render(
            'tags/edit.html.twig',
            [
                'tag' => $tag,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP Request
     * @param \AppBundle\Entity\Tag                     $tag     Tag entity
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     requirements={"id": "[1-9]\d*"},
     *     name="tags_delete",
     * )
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, Tag $tag)
    {
        $form = $this->createForm(FormType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tagsRepository->delete($tag);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('tag_index');
        }

        return $this->render(
            'tags/delete.html.twig',
            [
                'tag' => $tag,
                'form' => $form->createView(),
            ]
        );
    }
}