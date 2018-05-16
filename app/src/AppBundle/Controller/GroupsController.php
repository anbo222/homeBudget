<?php
/**
 * Groups controller.
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use AppBundle\Form\GroupType;
use AppBundle\Repository\GroupsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GroupsController.
 *
 * @package AppBundle\Controller
 *
 * @Route("/groups")
 */
class GroupsController extends Controller
{
    /**
     * Groups repository.
     *
     * @var \AppBundle\Repository\GroupsRepository|null Group repository
     */
    protected $groupsRepository = null;

    /**
     * GroupsController constructor.
     *
     * @param \AppBundle\Repository\GroupsRepository $groupsRepository Group repository
     */
    public function __construct(GroupsRepository $groupsRepository)
    {
        $this->groupsRepository = $groupsRepository;
    }

    /**
     * Index action.
     *
     * @param integer $page Current page number
     *
     * @Route(
     *     "/",
     *     defaults={"page": 1},
     *     name="groups_index",
     * )
     * @Route(
     *     "/page/{page}",
     *     requirements={"page": "[1-9]\d*"},
     *     name="groups_index_paginated",
     * )
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     */
    public function indexAction($page)
    {
        $groups = $this->groupsRepository->findAllPaginated($page);

        return $this->render(
            'groups/index.html.twig',
            ['groups' => $groups]
        );
    }

    /**
     * View action.
     *
     * @param Group $group Group entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}",
     *     requirements={"id": "[1-9]\d*"},
     *     name="groups_view",
     * )
     * @Method("GET")
     */
    public function viewAction(Group $group)
    {
        return $this->render(
            'groups/view.html.twig',
            ['group' => $group]
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
     *     name="groups_add",
     * )
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->groupsRepository->save($group);
            $this->addFlash('success', 'message.created_successfully');

            return $this->redirectToRoute('groups_index');
        }

        return $this->render(
            'groups/add.html.twig',
            [
                'group' => $group,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request   HTTP      Request
     * @param \AppBundle\Entity\Group                   $group     Group     entity
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     requirements={"id": "[1-9]\d*"},
     *     name="groups_edit",
     * )
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Group $group)
    {
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->groupsRepository->save($group);
            $this->addFlash('success', 'message.modified_successfully');

            return $this->redirectToRoute('groups_index');
        }

        return $this->render(
            'groups/edit.html.twig',
            [
                'group' => $group,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request   HTTP      Request
     * @param \AppBundle\Entity\Group                   $group     Group     entity
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     requirements={"id": "[1-9]\d*"},
     *     name="groups_delete",
     * )
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, Group $group)
    {
        $form = $this->createForm(FormType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->groupsRepository->delete($group);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('groups_index');
        }

        return $this->render(
            'groups/delete.html.twig',
            [
                'group' => $group,
                'form' => $form->createView(),
            ]
        );
    }
}
