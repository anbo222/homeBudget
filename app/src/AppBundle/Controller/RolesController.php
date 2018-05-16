<?php
/**
 * Roles controller.
 */
namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use AppBundle\Form\RoleType;
use AppBundle\Repository\RolesRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RolesController.
 *
 * @package AppBundle\Controller
 *
 * @Route("/roles")
 */
class RolesController extends Controller
{
    /**
     * Roles repository.
     *
     * @var \AppBundle\Repository\RolesRepository|null Role repository
     */
    protected $rolesRepository = null;

    /**
     * RolesController constructor.
     *
     * @param \AppBundle\Repository\RolesRepository $rolesRepository Role repository
     */
    public function __construct(RolesRepository $rolesRepository)
    {
        $this->rolesRepository = $rolesRepository;
    }

    /**
     * Index action.
     *
     * @param integer $page Current page number
     *
     * @Route(
     *     "/",
     *     defaults={"page": 1},
     *     name="roles_index",
     * )
     * @Route(
     *     "/page/{page}",
     *     requirements={"page": "[1-9]\d*"},
     *     name="roles_index_paginated",
     * )
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     */
    public function indexAction($page)
    {
        $roles = $this->rolesRepository->findAllPaginated($page);

        return $this->render(
            'roles/index.html.twig',
            ['roles' => $roles]
        );
    }

    /**
     * View action.
     *
     * @param Role $role Role entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @Route(
     *     "/{id}",
     *     requirements={"id": "[1-9]\d*"},
     *     name="roles_view",
     * )
     * @Method("GET")
     */
    public function viewAction(Role $role)
    {
        return $this->render(
            'roles/view.html.twig',
            ['role' => $role]
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
     *     name="roles_add",
     * )
     * @Method({"GET", "POST"})
     */
    public function addAction(Request $request)
    {
        $role = new Role();
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->rolesRepository->save($role);
            $this->addFlash('success', 'message.created_successfully');

            return $this->redirectToRoute('roles_index');
        }

        return $this->render(
            'roles/add.html.twig',
            [
                'role' => $role,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request   HTTP      Request
     * @param \AppBundle\Entity\Role                    $role      Role      entity
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     requirements={"id": "[1-9]\d*"},
     *     name="roles_edit",
     * )
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Role $role)
    {
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->rolesRepository->save($role);
            $this->addFlash('success', 'message.modified_successfully');

            return $this->redirectToRoute('roles_index');
        }

        return $this->render(
            'roles/edit.html.twig',
            [
                'role' => $role,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request   HTTP      Request
     * @param \AppBundle\Entity\Role                    $role      Role      entity
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response HTTP Response
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     requirements={"id": "[1-9]\d*"},
     *     name="roles_delete",
     * )
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, Role $role)
    {
        $form = $this->createForm(FormType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->rolesRepository->delete($role);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('roles_index');
        }

        return $this->render(
            'roles/delete.html.twig',
            [
                'role' => $role,
                'form' => $form->createView(),
            ]
        );
    }
}
